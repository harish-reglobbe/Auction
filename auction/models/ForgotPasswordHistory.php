<?php

namespace auction\models;

use auction\components\Auction;
use auction\components\helpers\DatabaseHelper;
use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

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
class ForgotPasswordHistory extends \yii\db\ActiveRecord
{
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
        return '{{%forgot_password_history}}';
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
     * @param id user id of the user
     * @return bool status of save model
     */
    public function generatePasswordResetToken($userId)
    {
        $this->makeTokenInValid($userId);

        $_model= new ForgotPasswordHistory();
        $_model->token = Auction::$app->security->generateRandomString() . '_' . time();
        $_model->valid_till = Auction::$app->formatter->asDatetime(DatabaseHelper::EMAIL_TOKEN_VALID_TIME);
        $_model->status = DatabaseHelper::ACTIVE;
        $_model->user = $userId;
        $_model->mode= '1';

        if($_model->save()){
            return $_model->token;
        }

        return false;
    }


    /**
     * Finds out if password reset token is valid and make it as invalid Token
     *
     * @param string $token password reset token
     * @return boolean
     */
    private function makeTokenInValid($userId)
    {

        Auction::$app->db->createCommand()->update(self::tableName(),[
            'status' => DatabaseHelper::IN_ACTIVE
        ],'user=:user and status=:status',[
            ':user' => $userId,
            ':status' => DatabaseHelper::ACTIVE
        ])->execute();

    }

}
