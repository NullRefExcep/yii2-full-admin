<?php

use dektrium\user\models\User;
use nullref\fulladmin\models\Admin;
use yii\db\Migration;
use yii\db\Schema;
use yii\rbac\BaseManager;

class m000000_000001_create_admin_user extends Migration
{
    public function up()
    {
        $user = Yii::createObject([
            'class' => User::className(),
            'scenario' => 'create',
            'email' => 'admin@test.com',
            'username' => 'admin',
            'password' => 'password',
        ]);

        if ($user->create()) {
            $this->stdout(Yii::t('admin', 'User has been created') . "!\n", Console::FG_GREEN);
        }

        $this->stdout("Username: 'admin'\n");
        $this->stdout("Password: 'password'\n");

    }

    public function down()
    {
        $admin = User::find()->andWhere(['username' => 'admin']);
        if ($admin !== null) {
            $admin->delete();
        }
        return true;
    }

}
