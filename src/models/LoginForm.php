<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace nullref\fulladmin\models;

use dektrium\user\models\LoginForm as BaseLoginForm;
use Yii;

class LoginForm extends BaseLoginForm
{
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['isAdmin']
            = [
            'login',
            function ($attribute) {
                return $this->user !== null && $this->user->isAdmin;
            }
        ];
        return $rules;
    }


    public function attributeLabels()
    {
        return [
            'username' => Yii::t('admin', 'Username'),
            'password' => Yii::t('admin', 'Password'),
            'rememberMe' => Yii::t('admin', 'Remember Me'),
        ];
    }
} 