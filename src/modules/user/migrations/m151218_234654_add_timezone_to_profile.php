<?php

use yii\db\Schema;
use yii\db\Migration;

class m151218_234654_add_timezone_to_profile extends Migration
{
    public function up()
    {
        $this->addColumn('{{%profile}}', 'timezone', Schema::TYPE_STRING . '(40)');
    }

    public function down()
    {
        $this->dropcolumn('{{%profile}}', 'timezone');
    }

}
