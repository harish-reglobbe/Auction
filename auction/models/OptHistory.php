<?php

namespace auction\models;

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
class OptHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%opt_history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user', 'otp', 'mode', 'create_date', 'valid_till', 'status'], 'required'],
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
}
