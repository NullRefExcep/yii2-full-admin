<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */

namespace nullref\fulladmin;

use nullref\core\components\ModuleInstaller;
use nullref\core\console\MigrateController;
use yii\helpers\Console;

class Installer extends ModuleInstaller
{
    public function getModuleId()
    {
        return 'admin';
    }

    public function install()
    {
        if ($this->runModuleMigrations || \Yii::$app->controller->confirm('Run user module migrations')) {
            \Yii::$app->getModule('core')->controllerMap['migrate'] = [
                'class' => MigrateController::className(),
                'migrationNamespaces' => [
                    'nullref\fulladmin\modules\user\migrations',
                ],
            ];
            \Yii::$app->runAction('core/migrate/up', ['all',
                'interactive' => false,
            ]);
        }

        parent::install();
        if (Console::confirm('Create assets files?')) {
            try {
                $this->createFile('@webroot/js/admin/scripts.js');
                echo 'File @webroot/js/admin/scripts.js was created' . PHP_EOL;

                $this->createFile('@webroot/css/admin/main.css');
                echo 'File @webroot/css/admin/main.css was created' . PHP_EOL;
            } catch (\Exception $e) {
                echo $e->getMessage() . PHP_EOL;
            }
        }
    }

    public function uninstall()
    {
        parent::uninstall();

        if ($this->runModuleMigrations || \Yii::$app->controller->confirm('Run down user module migrations')) {
            \Yii::$app->getModule('core')->controllerMap['migrate'] = [
                'class' => MigrateController::className(),
                'migrationNamespaces' => [
                    'nullref\fulladmin\modules\user\migrations',
                ],
            ];
            \Yii::$app->runAction('core/migrate/down', ['all',
                'moduleId' => 'user',
                'interactive' => false,
            ]);
        }
    }

    protected function removeFromConfig()
    {
        $path = $this->getConfigPath();
        $config = require($path);

        if (isset($config['user'])) {
            unset($config['user']);
        }

        if (isset($config['admin'])) {
            unset($config['admin']);
        }
        $this->writeArrayToFile($this->getConfigPath(), $config);
    }


    protected function addToConfig()
    {
        $path = $this->getConfigPath();
        $config = require($path);

        $config['admin'] = $this->getConfigArray();
        $config['user'] = [
            'class' => 'nullref\fulladmin\modules\user\Module',
        ];

        $this->writeArrayToFile($this->getConfigPath(), $config);
    }

}