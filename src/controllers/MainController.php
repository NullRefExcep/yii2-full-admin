<?php

namespace nullref\fulladmin\controllers;

use dektrium\user\filters\AccessRule;
use nullref\fulladmin\components\AdminController;
use nullref\fulladmin\filters\AccessControl;
use nullref\fulladmin\models\LoginForm;
use Yii;
use yii\web\Response;

/**
 *
 */
class MainController extends AdminController
{
    public $dashboardPage = ['/admin'];

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'login', 'index', 'error'],
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'class' => AccessRule::className(),
                        'actions' => ['index', 'logout'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'nullref\fulladmin\actions\ErrorAction',
            ],
        ];
    }

    public function actionLogin()
    {
        $this->layout = 'base';

        /** @var LoginForm $model */
        $model = Yii::createObject(LoginForm::className());

        if ($model->load(\Yii::$app->request->post())) {
            if ($model->validate() && $model->login()) {
                return $this->redirect(Yii::$app->user->getReturnUrl($this->dashboardPage));
            } else {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return $model->errors;
                }
            }
        }
        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->getUser()->logout();

        return $this->goHome();
    }

}