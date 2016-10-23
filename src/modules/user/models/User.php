<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */


namespace nullref\fulladmin\modules\user\models;


use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{
    /**
     * @return bool Whether the user is an admin or not.
     */
    public function getIsAdmin()
    {
        return parent::getIsAdmin() || $this->getAttribute('is_admin');
    }

}