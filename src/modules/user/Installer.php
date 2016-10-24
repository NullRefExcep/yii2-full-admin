<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */

namespace nullref\fulladmin\modules\user;

use nullref\core\components\ModuleInstaller;
use nullref\core\console\MigrateController;
use yii\helpers\Console;

class Installer extends ModuleInstaller
{
    public function getModuleId()
    {
        return 'user';
    }

    protected function getConfigArray()
    {
        $config = parent::getConfigArray();
        $config['controllerMap'] = [
            'admin' => 'nullref\fulladmin\modules\user\controllers\AdminController',
            'registration' => [
                'class' => 'dektrium\user\controllers\RegistrationController',
                'viewPath' => '@dektrium/user/views/registration',
            ],
        ];
        return $config;
    }


}