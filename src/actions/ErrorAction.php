<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */

namespace nullref\fulladmin\actions;

use yii\web\ErrorAction as BaseErrorAction;

class ErrorAction extends BaseErrorAction
{
    /**
     * @return bool
     */
    protected function beforeRun()
    {
        $this->controller->layout = '@vendor/nullref/yii2-full-admin/src/views/layouts/error';

        return parent::beforeRun();
    }
}