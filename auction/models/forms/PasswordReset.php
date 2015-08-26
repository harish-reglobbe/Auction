<?php

namespace auction\models\forms;

use auction\components\Auction;
use auction\models\Users;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordReset extends Model
{
    public $username;
    public $via;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            [['username','via'], 'required'],
            ['username','email','when' => function ($model) {return $model->via == 'email';}, 'whenClient' => "function (attribute, value) {return $(#PasswordReset[via]).val() == 'email';}",'message' => 'Must be a Valid Email'],
            ['username','integer','min' => 10,'max' => 10,'when' => function ($model) {return $model->via == 'sms';}, 'whenClient' => "function (attribute, value) {return $(#PasswordReset[via]).val() == 'sms';}",'message' => 'Must Be a Valid Mobile Number']

        ];
    }

    public function attributeLabels(){
        return [
            'username' => 'Email/Mobile',
            'via' => 'Token Sender'
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = Users::findByUsername($this->username);

        if ($user) {

            if ($user->token) {
                //Make Reset Password Token Invalid to user and return new valid token to user
                $_token = $user->token->generatePasswordResetToken($user->id);
            }

            if ($_token) {
                //Send Mail to user
//                return Auction::$app->mailer->compose('passwordResetToken-html',['user' => $user,'token' => $_token])
//                    ->setFrom([Auction::$app->params['supportEmail'] => Auction::$app->name . ' robot'])
//                    ->setTo($this->username)
//                    ->setSubject('Password reset for ' . Auction::$app->name)
//                    ->send();

                return true;
            }
        }

        return false;
    }
}
