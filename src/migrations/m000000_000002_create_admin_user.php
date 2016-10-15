<?php

use dektrium\user\models\User;
use yii\db\Migration;
use yii\helpers\Console;

class m000000_000002_create_admin_user extends Migration
{
    public function up()
    {
        $user = Yii::createObject([
            'class' => User::className(),
            'scenario' => 'create',
            'email' => 'admin@test.com',
            'username' => 'admin',
            'password' => 'password',
            'is_admin' => true,
        ]);

        if ($user->create()) {
            Console::output(Yii::t('admin', 'User has been created'));
        }

        Console::output("Username: 'admin'");
        Console::output("Password: 'password'");

    }

    public function down()
    {
        $admin = User::find()->andWhere(['username' => 'admin'])->one();
        if ($admin !== null) {
            $admin->delete();
            Console::output('Admin user was deleted');
        }
        return true;
    }

}
