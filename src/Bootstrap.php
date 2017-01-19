<?php
namespace nullref\fulladmin;

use dektrium\user\filters\AccessRule;
use nullref\fulladmin\filters\AccessControl;
use yii\base\Module as BaseModule;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Controller;
use yii\base\Event;
use yii\gii\Module as Gii;
use yii\i18n\PhpMessageSource;
use yii\web\Application as WebApplication;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        /** @var Module $module */
        if ((($module = $app->getModule('admin')) == null) || !($module instanceof Module)) {
            return;
        };

        /** I18n */
        if (!isset($app->get('i18n')->translations['admin*'])) {
            $app->i18n->translations['admin*'] = [
                'class' => PhpMessageSource::className(),
                'basePath' => 'nullref/fulladmin/messages',
            ];
        }

        if ($app instanceof WebApplication) {

            $app->urlManager->addRules(['/admin/login' => '/admin/main/login']);
            $app->urlManager->addRules(['/admin/logout' => '/admin/main/logout']);


            Event::on(BaseModule::className(), BaseModule::EVENT_BEFORE_ACTION, function () use ($module) {
                if (Yii::$app->controller instanceof IAdminController) {
                    /** @var Controller $controller */
                    $controller = Yii::$app->controller;

                    $controller->layout = $module->layout;
                    if ($controller->module != $module) {
                        $controller->module->setLayoutPath($module->getLayoutPath());
                    }
                    if (!isset($controller->behaviors()['access'])) {
                        $controller->attachBehavior('access', [
                            'class' => AccessControl::className(),
                            'rules' => [
                                [
                                    'class' => AccessRule::className(),
                                    'allow' => true,
                                    'roles' => ['admin'],
                                ],
                            ],
                        ]);
                    }
                    Yii::$app->errorHandler->errorAction = $module->errorAction;
                }
            });


        }

        if (YII_ENV_DEV && class_exists('yii\gii\Module')) {
            Event::on(Gii::className(), Gii::EVENT_BEFORE_ACTION, function (Event $event) {
                /** @var Gii $gii */
                $gii = $event->sender;
                $gii->generators['crud'] = [
                    'class' => 'yii\gii\generators\crud\Generator',
                    'templates' => [
                        'admin-crud' => '@nullref/fulladmin/generators/crud/admin',
                    ]
                ];
                $gii->generators['stuff'] = [
                    'class' => 'nullref\fulladmin\generators\stuff\Generator',
                    'templates' => [
                        'default' => '@nullref/fulladmin/generators/stuff/default',
                    ]
                ];
            });
        }
    }
}
