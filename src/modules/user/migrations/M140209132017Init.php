<?php

namespace nullref\fulladmin\modules\user\migrations;

use dektrium\user\migrations\Migration;
use yii\db\Schema;

/**
 * @author Dmitry Erofeev <dmeroff@gmail.com
 */
class M140209132017Init extends Migration
{
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . '(255)',
            'email' => Schema::TYPE_STRING . '(255) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . '(60) NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'confirmation_token' => Schema::TYPE_STRING . '(32)',
            'confirmation_sent_at' => Schema::TYPE_INTEGER,
            'confirmed_at' => Schema::TYPE_INTEGER,
            'unconfirmed_email' => Schema::TYPE_STRING . '(255)',
            'recovery_token' => Schema::TYPE_STRING . '(32)',
            'recovery_sent_at' => Schema::TYPE_INTEGER,
            'blocked_at' => Schema::TYPE_INTEGER,
            'registered_from' => Schema::TYPE_INTEGER,
            'logged_in_from' => Schema::TYPE_INTEGER,
            'logged_in_at' => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $this->tableOptions);

        $this->createIndex('user_unique_username', '{{%user}}', 'username', true);
        $this->createIndex('user_unique_email', '{{%user}}', 'email', true);
        $this->createIndex('user_confirmation', '{{%user}}', 'id, confirmation_token', true);
        $this->createIndex('user_recovery', '{{%user}}', 'id, recovery_token', true);

        $this->createTable('{{%profile}}', [
            'user_id' => Schema::TYPE_INTEGER . ' PRIMARY KEY',
            'name' => Schema::TYPE_STRING . '(255)',
            'public_email' => Schema::TYPE_STRING . '(255)',
            'gravatar_email' => Schema::TYPE_STRING . '(255)',
            'gravatar_id' => Schema::TYPE_STRING . '(32)',
            'location' => Schema::TYPE_STRING . '(255)',
            'website' => Schema::TYPE_STRING . '(255)',
            'bio' => Schema::TYPE_TEXT,
        ], $this->tableOptions);

        $this->addForeignKey('fk_user_profile', '{{%profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%account}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'provider' => Schema::TYPE_STRING . ' NOT NULL',
            'client_id' => Schema::TYPE_STRING . ' NOT NULL',
            'properties' => Schema::TYPE_TEXT,
        ], $this->tableOptions);

        $this->createIndex('account_unique', '{{%account}}', ['provider', 'client_id'], true);
        $this->addForeignKey('fk_user_account', '{{%account}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');


        // user table
        $this->dropIndex('user_confirmation', '{{%user}}');
        $this->dropIndex('user_recovery', '{{%user}}');
        $this->dropColumn('{{%user}}', 'confirmation_token');
        $this->dropColumn('{{%user}}', 'confirmation_sent_at');
        $this->dropColumn('{{%user}}', 'recovery_token');
        $this->dropColumn('{{%user}}', 'recovery_sent_at');
        $this->dropColumn('{{%user}}', 'logged_in_from');
        $this->dropColumn('{{%user}}', 'logged_in_at');
        $this->renameColumn('{{%user}}', 'registered_from', 'registration_ip');
        $this->addColumn('{{%user}}', 'flags', Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0');

        // account table
        $this->renameColumn('{{%account}}', 'properties', 'data');


        $this->createTable('{{%token}}', [
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'code' => Schema::TYPE_STRING . '(32) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'type' => Schema::TYPE_SMALLINT . ' NOT NULL',
        ], $this->tableOptions);

        $this->createIndex('token_unique', '{{%token}}', ['user_id', 'code', 'type'], true);
        $this->addForeignKey('fk_user_token', '{{%token}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

        $this->alterColumn('{{%user}}', 'registration_ip', Schema::TYPE_BIGINT);

        $this->renameTable('{{%account}}', '{{%social_account}}');


        $this->addColumn('{{%social_account}}', 'code', Schema::TYPE_STRING . '(32)');
        $this->addColumn('{{%social_account}}', 'created_at', Schema::TYPE_INTEGER);
        $this->addColumn('{{%social_account}}', 'email', Schema::TYPE_STRING);
        $this->addColumn('{{%social_account}}', 'username', Schema::TYPE_STRING);
        $this->createIndex('account_unique_code', '{{%social_account}}', 'code', true);


        if ($this->db->driverName === 'pgsql') {
            $this->alterColumn('{{%user}}', 'username', 'SET NOT NULL');
        } else {
            $this->alterColumn('{{%user}}', 'username', Schema::TYPE_STRING . '(255) NOT NULL');
        }

        $this->addColumn('{{%profile}}', 'timezone', Schema::TYPE_STRING . '(40)');

    }

    public function down()
    {
        $this->dropColumn('{{%profile}}', 'timezone');

        if (\Yii::$app->db->driverName == "pgsql") {
            $this->alterColumn('{{%user}}', 'username', 'DROP NOT NULL');
        } else {
            $this->alterColumn('{{%user}}', 'username', Schema::TYPE_STRING . '(255)');
        }

        $this->dropIndex('account_unique_code', '{{%social_account}}');
        $this->dropColumn('{{%social_account}}', 'email');
        $this->dropColumn('{{%social_account}}', 'username');
        $this->dropColumn('{{%social_account}}', 'code');
        $this->dropColumn('{{%social_account}}', 'created_at');

        $this->renameTable('{{%social_account}}', '{{%account}}');

        $this->alterColumn('{{%user}}', 'registration_ip', Schema::TYPE_INTEGER);

        $this->dropTable('{{%token}}');

        // account table
        $this->renameColumn('{{%account}}', 'data', 'properties');

        // user table
        $this->dropColumn('{{%user}}', 'flags');
        $this->renameColumn('{{%user}}', 'registration_ip', 'registered_from');
        $this->addColumn('{{%user}}', 'logged_in_at', Schema::TYPE_INTEGER);
        $this->addColumn('{{%user}}', 'logged_in_from', Schema::TYPE_INTEGER);
        $this->addColumn('{{%user}}', 'recovery_sent_at', Schema::TYPE_INTEGER);
        $this->addColumn('{{%user}}', 'recovery_token', Schema::TYPE_STRING . '(32)');
        $this->addColumn('{{%user}}', 'confirmation_sent_at', Schema::TYPE_INTEGER);
        $this->addColumn('{{%user}}', 'confirmation_token', Schema::TYPE_STRING . '(32)');
        $this->createIndex('user_confirmation', '{{%user}}', 'id, confirmation_token', true);
        $this->createIndex('user_recovery', '{{%user}}', 'id, recovery_token', true);

        $this->dropTable('{{%account}}');

        $this->dropTable('{{%profile}}');
        $this->dropTable('{{%user}}');
    }
}
