<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * PasswordForm is the model behind the change password form.
 */
class PasswordForm extends Model
{
    public $currentPassword;
    public $newPassword;
    public $confirmNewPassword;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'confirmNewPassword'], 'required'],
            ['currentPassword', 'validatePassword'],
            ['newPassword', 'string', 'min' => 4, 'max' => '32'],
            ['confirmNewPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Password does not match.']
        ];
    }

    /**
     * Validates current password.
     * This method serves as the inline validation for current password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        $user = Yii::$app->user->identity;

        if (!$user->validatePassword($this->currentPassword)) {
            $this->addError($attribute, 'Incorrect password.');
        }
    }
}
