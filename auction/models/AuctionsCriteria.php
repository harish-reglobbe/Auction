<?php

namespace auction\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%auctions_criteria}}".
 *
 * @property integer $id
 * @property integer $auction
 * @property double $security
 * @property integer $is_percent
 * @property string $create_date
 * @property string $update_date
 * @property integer $is_active
 *
 * @property Auctions $auction0
 */
class AuctionsCriteria extends \yii\db\ActiveRecord
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
        return '{{%auctions_criteria}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auction', 'is_percent', 'create_date', 'is_active'], 'required'],
            [['auction', 'is_percent', 'is_active'], 'integer'],
            [['security'], 'number'],
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
            'auction' => 'Auction',
            'security' => 'Security Deposit',
            'is_percent' => 'Percent Cost',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuction0()
    {
        return $this->hasOne(Auctions::className(), ['id' => 'auction']);
    }
}
