<?php

namespace auction\models;

use Yii;

/**
 * This is the model class for table "{{%lots}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $auction
 * @property string $condition
 * @property integer $lot_size
 * @property integer $is_quantity
 *
 * @property LotPreference[] $lotPreferences
 * @property Auctions $auction0
 * @property Products[] $products
 */
class Lots extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lots}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'auction', 'condition', 'lot_size', 'is_quantity'], 'required'],
            [['auction', 'lot_size', 'is_quantity'], 'integer'],
            [['name', 'condition'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'auction' => 'Auction',
            'condition' => 'Condition',
            'lot_size' => 'Lot Size',
            'is_quantity' => '0=:in amount,1=:in quantity',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLotPreferences()
    {
        return $this->hasMany(LotPreference::className(), ['lots' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuction0()
    {
        return $this->hasOne(Auctions::className(), ['id' => 'auction']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['lot' => 'id']);
    }
}
