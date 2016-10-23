<?php

namespace nullref\fulladmin\migrations;

use dektrium\user\models\User;
use Yii;
use yii\db\Migration;
use yii\helpers\Console;

class m151218_234656_create_admin_user extends Migration
{
    public function up()
    {
        /** @var \nullref\fulladmin\modules\user\models\User $user */
        $user = Yii::createObject([
            'class' => User::className(),
            'scenario' => 'create',
            'email' => 'admin@test.com',
            'username' => 'admin',
            'password' => 'password',
            'is_admin' => true,
        ]);
        $user->validate();

        print_r($user->getErrors());

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
