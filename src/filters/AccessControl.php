<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */


namespace nullref\fulladmin\filters;


use yii\filters\AccessControl as BaseAccessControl;

class AccessControl extends BaseAccessControl
{
    public function init()
    {
        parent::init();
        $this->user->loginUrl = '/admin/login';
    }

}