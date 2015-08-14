<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%brands}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property string $create_date
 * @property string $update_date
 * @property integer $is_active
 *
 * @property AuctionPreference[] $auctionPreferences
 * @property DealerCompanyPreferences[] $dealerCompanyPreferences
 * @property DealerPreference[] $dealerPreferences
 * @property LotPreference[] $lotPreferences
 * @property Products[] $products
 */
class Brands extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%brands}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'create_date', 'is_active'], 'required'],
            [['description'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['is_active'], 'integer'],
            [['name', 'image'], 'string', 'max' => 255]
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
            'description' => 'Description',
            'image' => 'Image',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuctionPreferences()
    {
        return $this->hasMany(AuctionPreference::className(), ['brand' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealerCompanyPreferences()
    {
        return $this->hasMany(DealerCompanyPreferences::className(), ['brand' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealerPreferences()
    {
        return $this->hasMany(DealerPreference::className(), ['brand' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLotPreferences()
    {
        return $this->hasMany(LotPreference::className(), ['brand' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['brand' => 'id']);
    }
}
