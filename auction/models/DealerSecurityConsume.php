<?php

namespace auction\models;

use Yii;

/**
 * This is the model class for table "{{%dealer_security_consume}}".
 *
 * @property integer $id
 * @property integer $security
 * @property integer $auction
 * @property double $amount
 * @property string $create_date
 * @property string $update_date
 * @property integer $status
 *
 * @property DealerSecurity $security0
 * @property Auctions $auction0
 */
class DealerSecurityConsume extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dealer_security_consume}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['security', 'auction', 'amount', 'create_date', 'status'], 'required'],
            [['security', 'auction', 'status'], 'integer'],
            [['amount'], 'number'],
            [['create_date', 'update_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'security' => 'dealer security id',
            'auction' => 'Auction',
            'amount' => 'Amount',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
            'status' => '0:-acquire, 1:-used, 2:-free',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSecurity0()
    {
        return $this->hasOne(DealerSecurity::className(), ['id' => 'security']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuction0()
    {
        return $this->hasOne(Auctions::className(), ['id' => 'auction']);
    }
}
