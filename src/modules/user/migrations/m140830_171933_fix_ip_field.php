<?php

namespace nullref\fulladmin\modules\user\migrations;

use yii\db\Migration;
use yii\db\Schema;

/**
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class m140830_171933_fix_ip_field extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%user}}', 'registration_ip', Schema::TYPE_BIGINT);
    }

    public function down()
    {
        $this->alterColumn('{{%user}}', 'registration_ip', Schema::TYPE_INTEGER);
    }
}
