<?php

namespace auction\models;

use auction\models\core\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%auction_preference}}".
 *
 * @property integer $auction
 * @property integer $category
 * @property integer $brand
 *
 * @property Auctions $auction0
 * @property Categories $category0
 * @property Brands $brand0
 */
class AuctionPreference extends ActiveRecord
{
    public function behaviors(){
        return [];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auction_preference}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auction', 'category'], 'required'],
            [['auction', 'category', 'brand'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auction' => 'Auction',
            'category' => 'Category',
            'brand' => 'Brand',
        ];
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

    public static function primaryKey(){
        return ['auction','category','brand'];
    }
}
