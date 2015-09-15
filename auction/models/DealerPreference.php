<?php

namespace auction\models;

use auction\components\Auction;
use auction\models\core\ActiveRecord;
use yii\base\InvalidValueException;
use yii\helpers\ArrayHelper;

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
class DealerPreference extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors(){
        return [];
    }

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
            [['dealer', 'category', 'brand'], 'integer'],
            ['dealer' , 'auction\models\validators\DealerPrefeneces']
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

    public static function primaryKey(){
        return ['dealer','brand','category'];
    }

    public function deletePreference($post){
        $model = self::find()->where([
            'brand'    => ArrayHelper::getValue($post , 'brand'),
            'category' => ArrayHelper::getValue($post , 'category'),
            'dealer'    => ArrayHelper::getValue($post , 'dealer'),
        ])->one();

        if ($model) {
            $model->delete();
            return true;
        }else{
            return false;
        }
    }

    public function addPreference($post){
        $this->brand = ArrayHelper::getValue($post , 'brand');
        $this->category = ArrayHelper::getValue($post ,'category');
        $this->dealer = Auction::dealer();

        if($this->save()){
            return true;
        }else {
            throw new InvalidValueException('Already Exist');
        }
    }
}