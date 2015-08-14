<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%dealer_preference}}".
 *
 * @property integer $dealer
 * @property integer $category
 * @property integer $brand
 *
 * @property Dealers $dealer0
 * @property Categories $category0
 * @property Brands $brand0
 */
class DealerPreference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dealer_preference}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dealer', 'category', 'brand'], 'required'],
            [['dealer', 'category', 'brand'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dealer' => 'Dealer',
            'category' => 'Category',
            'brand' => 'Brand',
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
    public function getCategory0()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand0()
    {
        return $this->hasOne(Brands::className(), ['id' => 'brand']);
    }
}
