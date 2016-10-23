<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */


namespace nullref\fulladmin\modules\user;


use dektrium\user\Module as BaseModule;
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
        ];
    }

    public function init()
    {
        parent::init();
        $this->controllerMap = array_merge([
            'admin' => 'nullref\fulladmin\modules\user\controllers\AdminController',
        ], $this->controllerMap);
    }
}