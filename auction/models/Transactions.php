<?php

namespace auction\models;

use Yii;

/**
 * This is the model class for table "{{%transactions}}".
 *
 * @property integer $txn_id
 * @property string $entered_by_user
 * @property double $txn_amount
 * @property integer $txn_is_debit
 * @property string $txn_date
 * @property string $paymentMode
 * @property string $txn_desc
 * @property boolean $visibility
 */
class Transactions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transactions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entered_by_user', 'txn_amount', 'txn_is_debit', 'txn_date', 'paymentMode'], 'required'],
            [['txn_amount'], 'number'],
            [['txn_is_debit'], 'integer'],
            [['txn_date'], 'safe'],
            [['visibility'], 'boolean'],
            [['entered_by_user'], 'string', 'max' => 50],
            [['paymentMode'], 'string', 'max' => 20],
            [['txn_desc'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'txn_id' => 'Txn ID',
            'entered_by_user' => 'Entered By User',
            'txn_amount' => 'Txn Amount',
            'txn_is_debit' => 'Txn Is Debit',
            'txn_date' => 'Txn Date',
            'paymentMode' => 'Payment Mode',
            'txn_desc' => 'Txn Desc',
            'visibility' => 'Visibility',
        ];
    }
}
