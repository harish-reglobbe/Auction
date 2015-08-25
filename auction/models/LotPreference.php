<?php

namespace auction\models;

use Yii;

/**
 * This is the model class for table "{{%lot_preference}}".
 *
 * @property integer $lots
 * @property integer $brand
 * @property integer $category
 *
 * @property Lots $lots0
 * @property Brands $brand0
 * @property Categories $category0
 */
class LotPreference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lot_preference}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lots', 'brand', 'category'], 'required'],
            [['lots', 'brand', 'category'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lots' => 'Lots',
            'brand' => 'Brand',
            'category' => 'Category',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLots0()
    {
        return $this->hasOne(Lots::className(), ['id' => 'lots']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand0()
    {
        return $this->hasOne(Brands::className(), ['id' => 'brand']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category']);
    }
}
