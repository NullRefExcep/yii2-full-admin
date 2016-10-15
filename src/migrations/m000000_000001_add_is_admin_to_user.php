<?php

use dektrium\user\models\User;
use yii\db\Migration;
use yii\helpers\Console;

class m000000_000001_add_is_admin_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'is_admin', $this->boolean()->defaultValue(false));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'is_admin');
    }

}
