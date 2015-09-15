<?php

namespace auction\models;

use auction\components\Auction;
use auction\models\core\ActiveRecord;
use Yii;
use yii\base\Exception;

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
class Lots extends ActiveRecord
{
    /**
     * @inheritdoc
     */

    public function behaviors(){
        return [];
    }
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
            [['name', 'auction', 'condition','lot_size', 'is_quantity'], 'required'],
            [['id','auction', 'lot_size', 'is_quantity'], 'integer'],
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
            'is_quantity' => 'Quantity',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLotPreferences()
    {
        return $this->hasOne(LotPreference::className(), ['lots' => 'id']);
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

    public function saveLot($request){
        $this->load($request);

        $transaction = Auction::$app->db->beginTransaction();
        try{
            if(!$this->save())
                return false;

            $preferences= new LotPreference();
            $preferences->load($request);

            $preferences->lots = $this->primaryKey;
            if($preferences->save()){
                $transaction->commit();
                return true;
            }

            return false;

        }catch(Exception $ex){
            Auction::error('Lot Not Saved Due to following Errors'.$ex->getMessage());
            $transaction->rollBack();
            return false;
        }

    }
}
