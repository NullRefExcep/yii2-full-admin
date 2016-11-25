<?php

namespace nullref\fulladmin\migrations;

use yii\db\Migration;

class M151218234655_add_is_admin_to_user extends Migration
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
