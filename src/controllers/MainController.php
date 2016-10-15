<?php

namespace nullref\fulladmin\controllers;

use nullref\fulladmin\components\AdminController;
use nullref\fulladmin\models\Admin;
use nullref\fulladmin\models\LoginForm;
use nullref\fulladmin\models\PasswordResetForm;
use Yii;
use nullref\fulladmin\components\AccessControl;
use yii\web\NotFoundHttpException;
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
                        'actions' => ['index', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
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

        $model = new LoginForm();

        if (!Yii::$app->get('admin')->isGuest) {
            return $this->redirect($this->dashboardPage);
        }

        if ($model->load(\Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->login();
                return $this->redirect($this->dashboardPage);
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
        Yii::$app->get('admin')->logout();

        return $this->goHome();
    }

}