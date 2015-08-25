<?php

namespace auction\models\forms;

use auction\components\Auction;
use Yii;
use yii\base\Model;
use auction\models\Users;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Email/Mobile',
            'password' => 'Password',
            'rememberMe' => 'Remember Me'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * Setting User Session variables
     * Auction::$app->session->set[]=[user.role,user.name]
     * If user belongs to company then its company Id alse setted as user.company session
     *
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();

            Auction::$app->session->set('user.role',$user->user_role);
            Auction::$app->session->set('user.name',$user->name);

            if($user->company !== null){
                Auction::$app->session->set('user.company',$user->company->id);
            }

            return Auction::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Users::findByUsername($this->username);
        }

        return $this->_user;
    }
}
