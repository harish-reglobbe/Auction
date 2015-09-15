<?php

namespace auction\models;

use auction\models\core\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%bids_term}}".
 *
 * @property integer $id
 * @property integer $max_bid
 * @property integer $cooling_prd
 * @property integer $last_min_extd
 * @property integer $max_extd
 * @property integer $auction
 *
 * @property Auctions $auction0
 */
class BidsTerm extends ActiveRecord
{
    public function behaviors(){
        return [];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bids_term}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['max_bid', 'cooling_prd', 'last_min_extd', 'max_extd', 'auction'], 'required'],
            [['max_bid', 'cooling_prd', 'last_min_extd', 'max_extd', 'auction'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'max_bid' => 'Max Bid',
            'cooling_prd' => 'Cooling period',
            'last_min_extd' => 'Last Minute extention',
            'max_extd' => 'Max extention',
            'auction' => 'Auction',
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
