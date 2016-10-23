<?php
namespace nullref\fulladmin\modules\user\controllers;

use dektrium\user\controllers\AdminController as BaseAdminController;
use nullref\core\interfaces\IAdminController;
use nullref\fulladmin\filters\AccessControl;

class AdminController extends BaseAdminController implements IAdminController
{

    /** @inheritdoc */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access']['class'] = AccessControl::className();
        return $behaviors;
    }
}