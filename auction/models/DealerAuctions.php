<?php

namespace auction\models;

use Yii;

/**
 * This is the model class for table "{{%dealer_auctions}}".
 *
 * @property integer $id
 * @property integer $dealer
 * @property integer $auction
 * @property string $create_date
 * @property string $update_date
 * @property integer $status
 * @property double $amount
 *
 * @property Dealers $dealer0
 * @property Auctions $auction0
 */
class DealerAuctions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dealer_auctions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dealer', 'auction', 'create_date', 'status'], 'required'],
            [['dealer', 'auction', 'status'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['amount'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dealer' => 'Dealer',
            'auction' => 'Auction',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
            'status' => 'Status',
            'amount' => 'bid amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealer0()
    {
        return $this->hasOne(Dealers::className(), ['id' => 'dealer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuction0()
    {
        return $this->hasOne(Auctions::className(), ['id' => 'auction']);
    }
}
