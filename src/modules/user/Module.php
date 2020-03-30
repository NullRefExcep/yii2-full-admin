<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */


namespace nullref\fulladmin\modules\user;


use dektrium\user\Module as BaseModule;
use yii\web\Application as WebApplication;
use nullref\core\interfaces\IAdminModule;
use Yii;

class Module extends BaseModule implements IAdminModule
{
    public $modelMap = [
        'User' => 'nullref\fulladmin\modules\user\models\User',
        'UserSearch' => 'nullref\fulladmin\modules\user\models\UserSearch',
    ];

    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('admin', 'Users'),
            'url' => ['/user/admin'],
            'icon' => 'users',
            'order' => 1,
            'roles' => ['admin.user'],
        ];
    }

    public function init()
    {
        $defaultControllerMap = (Yii::$app instanceof WebApplication) ? [
            'admin' => 'nullref\fulladmin\modules\user\controllers\AdminController',
            'registration' => [
                'class' => 'dektrium\user\controllers\RegistrationController',
                'viewPath' => '@dektrium/user/views/registration',
            ],
            'security' => [
                'class' => 'dektrium\user\controllers\SecurityController',
                'viewPath' => '@dektrium/user/views/security',
            ],
        ] : [];
        $this->controllerMap = array_merge($defaultControllerMap, $this->controllerMap);
        parent::init();
    }
}
