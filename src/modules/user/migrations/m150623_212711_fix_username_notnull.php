<?php

namespace nullref\fulladmin\modules\user\migrations;

use Yii;
use yii\db\Migration;
use yii\db\Schema;

class m150623_212711_fix_username_notnull extends Migration
{
    public function up()
    {
        if ($this->db->driverName === 'pgsql') {
            $this->alterColumn('{{%user}}', 'username', 'SET NOT NULL');
        } else {
            $this->alterColumn('{{%user}}', 'username', Schema::TYPE_STRING . '(255) NOT NULL');
        }
    }

    public function down()
    {
        if(Yii::$app->db->driverName == "pgsql"){
            $this->alterColumn('{{%user}}', 'username', 'DROP NOT NULL');
        }else{
            $this->alterColumn('{{%user}}', 'username', Schema::TYPE_STRING . '(255)');
        }
    }
}
