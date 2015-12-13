<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * ContactForm is the model behind the contact form.
 */
class RegisterForm extends Model
{
    public $username;
    public $password;
    public $confirmPassword;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password', 'confirmPassword'], 'required'],
            ['username', 'string', 'min' => 4, 'max' => 128],
            ['username', 'email'],
            ['username', 'validateUsername'],
            ['password', 'string', 'min' => 4, 'max' => 32],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Password does not match.'],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'username' => 'E-mail',
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Registers a new user
     * @return boolean if registration is successful
     */
    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            
            $user->username = $this->username;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generateAccessToken();
            
            if ($user->save()) {
                Yii::$app->mailer->compose()
                    ->setTo($user->username)
                    ->setFrom([Yii::$app->params['adminEmail'] => 'HomeBudget.ie'])
                    ->setSubject('Welcome to HomeBudget.ie')
                    ->setTextBody('Thank you for signing up with HomeBudget.ie. This is only confirmation message, please do not reply.')
                    ->send();
                
                return Yii::$app->user->login($user, 0);
            }
            
        }
        return false;
    }
    
    /**
     * Validates username.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateUsername($attribute, $params)
    {
        if (User::findByUsername($this->username) !== null) {
            $this->addError($attribute, 'E-mail is already in use.');
        }
    }
}
