<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */


namespace nullref\fulladmin\modules\user;


use nullref\core\interfaces\IAdminModule;
use Yii;

class Module extends \dektrium\user\Module implements IAdminModule
{

    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('admin', 'Users'),
            'url' => ['/user/admin'],
            'icon' => 'users',
        ];
    }
}