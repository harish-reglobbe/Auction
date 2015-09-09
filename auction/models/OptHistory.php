<?php

namespace auction\models;

use auction\components\Auction;
use auction\components\EventHandler;
use auction\components\Events;
use auction\components\helpers\DatabaseHelper;
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

class OptHistory extends \yii\db\ActiveRecord
{
    public $userObject ;
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_date',
                'updatedAtAttribute' => 'update_date',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%opt_history}}';
    }

    public function init(){
        $this->on(Events::TOKEN_INVALID, [EventHandler::className(), 'TokenInvalid']);
        $this->on(Events::SEND_RESET_TOKEN, [EventHandler::className(), 'SendResetToken']);
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
     * @param id user id of the user
     * @return bool status of save model
     */
    public function generatePasswordResetToken()
    {
        $this->trigger(Events::TOKEN_INVALID);

        $this->user = $this->userObject->id;
        $this->otp = Auction::$app->security->generateRandomString(6);
        $this->valid_till = Auction::$app->formatter->asDatetime(DatabaseHelper::SMS_TOKEN_VALID_TIME);
        $this->status = DatabaseHelper::ACTIVE;
        $this->mode= DatabaseHelper::TOKEN_SEND_MODE_WEB;

        if($this->save()){
            $_message = Auction::loggerMessageFormat('Opt History Token is created with following options ', $this->getAttributes());

            Auction::info($_message);

            $this->trigger(Events::SEND_RESET_TOKEN);
            return true;
        }
        else{
            $_message = Auction::loggerMessageFormat('Opt History Token has following validation error  ', $this->getErrors());

            Auction::error($_message);
            return false;
        }
    }

}
