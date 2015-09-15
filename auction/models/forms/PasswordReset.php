<?php

namespace auction\models\forms;

use auction\components\Auction;
use auction\models\ForgotPasswordHistory;
use auction\models\OptHistory;
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
            ['username' ,'auction\models\validators\UserValidator']
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
        /* @var $user  from User validator user variable */

        $user = $this->validators[2]->user;
        Auction::info('User is ready to sent a new Token');

        switch ($this->via){
            case 'email' :
                ForgotPasswordHistory::model()->generateOtp($user);
                break;

            case 'sms':
                OptHistory::model()->generateOtp($user);
        }
        return false;
    }
}
