<?php

use yii\db\Migration;
use yii\db\Schema;

class m141222_135246_alter_username_length extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%user}}', 'username', Schema::TYPE_STRING . '(255)');
    }

    public function down()
    {
        $this->alterColumn('{{%user}}', 'username', Schema::TYPE_STRING . '(25)');
    }
}
