<?php

namespace auction\models;

use Yii;

/**
 * This is the model class for table "{{%payment_history}}".
 *
 * @property integer $id
 * @property string $companyId
 * @property string $paymentId
 * @property string $paymentStatus
 * @property string $dateTime
 * @property string $paymentMode
 * @property string $paymentReference
 * @property string $paidBy
 * @property string $description
 */
class PaymentHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payment_history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['companyId', 'paymentId', 'paymentStatus', 'dateTime', 'paymentMode', 'paymentReference', 'paidBy'], 'required'],
            [['dateTime'], 'safe'],
            [['companyId', 'paidBy'], 'string', 'max' => 32],
            [['paymentId', 'paymentStatus'], 'string', 'max' => 255],
            [['paymentMode', 'paymentReference'], 'string', 'max' => 20],
            [['description'], 'string', 'max' => 5000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'companyId' => 'Company ID',
            'paymentId' => 'Payment ID',
            'paymentStatus' => 'Payment Status',
            'dateTime' => 'Date Time',
            'paymentMode' => 'Payment Mode',
            'paymentReference' => 'Payment Reference',
            'paidBy' => 'Paid By',
            'description' => 'Description',
        ];
    }
}
