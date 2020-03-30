<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */


namespace nullref\fulladmin\modules\user\models;


use dektrium\user\helpers\Password;
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

    /**
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['isAdminBoolean'] = ['is_admin', 'boolean'];
        return $rules;
    }

    /**
     * Avoid validation issue
     *
     * @param bool $runValidation
     * @param array $validationAttributes
     *
     * @return bool
     * @throws \Exception
     */
    public function createCustom($runValidation = true, $validationAttributes = [])
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }
        $transaction = $this->getDb()->beginTransaction();
        try {
            $this->password = ($this->password == null && $this->module->enableGeneratingPassword)
                ? Password::generate(8)
                : $this->password;
            $this->trigger(self::BEFORE_CREATE);
            if (!$this->save($runValidation, $validationAttributes)) {
                $transaction->rollBack();

                return false;
            }
            $this->confirm();
            $this->mailer->sendWelcomeMessage($this, null, true);
            $this->trigger(self::AFTER_CREATE);
            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            \Yii::warning($e->getMessage());
            throw $e;
        }
    }
}
