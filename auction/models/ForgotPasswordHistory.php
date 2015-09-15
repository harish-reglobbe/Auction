<?php

namespace auction\models;

use auction\components\Auction;
use auction\components\EventHandler;
use auction\components\Events;
use auction\models\core\ActiveRecord;
use yii\base\Event;
use yii\web\HttpException;

/**
 * This is the model class for table "{{%forgot_password_history}}".
 *
 * @property integer $id
 * @property integer $user
 * @property string $token
 * @property integer $mode
 * @property string $create_date
 * @property string $update_date
 * @property string $valid_till
 * @property integer $status
 *
 * @property Users $user0
 */
class ForgotPasswordHistory extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forgot_password_history}}';
    }

    public function init(){
        $this->on(Events::TOKEN_INVALID, [EventHandler::className(), 'TokenInvalid']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user', 'token', 'mode','valid_till', 'status'], 'required'],
            [['user', 'mode', 'status'], 'integer'],
            [['create_date', 'update_date', 'valid_till'], 'safe'],
            [['token'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'token' => 'for email',
            'mode' => '0=:opt,1=:token',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
            'valid_till' => 'Valid Till',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(Users::className(), ['id' => 'user']);
    }


    /**
     * Generates new password reset token
     * @param user User Object
     *
     * @throws  Http Exception
     */
    public function generateOtp($user)
    {
        $this->user =  $user->id;
        $this->trigger(Events::TOKEN_INVALID);

        $token = Auction::$app->security->generateRandomString(6);
        try{
            Auction::$app->db->createCommand("call create_email_otp ($user->id,'$token','$user->email')")->execute();
        }catch (Exception $Ex){
            throw new HttpException(400);
        }
    }

}
