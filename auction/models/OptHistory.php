<?php

namespace auction\models;

use auction\components\Auction;
use auction\components\EventHandler;
use auction\components\Events;
use auction\models\core\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%opt_history}}".
 *
 * @property integer $id
 * @property integer $user
 * @property string $otp
 * @property integer $mode
 * @property string $create_date
 * @property string $update_date
 * @property string $valid_till
 * @property integer $status
 *
 * @property Users $user0
 */
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class OptHistory extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%opt_history}}';
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
            [['user', 'otp', 'mode', 'valid_till', 'status'], 'required'],
            [['user', 'mode', 'status'], 'integer'],
            [['create_date', 'update_date', 'valid_till'], 'safe'],
            [['otp'], 'string', 'max' => 255]
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
            'otp' => 'Otp',
            'mode' => '0=:mobile,1=:web',
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
            Auction::$app->db->createCommand("call create_sms_otp ($user->id,'$token','$user->email')")->execute();
        }catch (Exception $Ex){
            throw new HttpException(400);
        }
    }
}
