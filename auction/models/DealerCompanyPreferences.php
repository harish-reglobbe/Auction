<?php

namespace auction\models;

use auction\models\core\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%dealer_company_preferences}}".
 *
 * @property integer $dc_id
 * @property integer $brand
 * @property integer $category
 *
 * @property DealerCompany $dc
 * @property Brands $brand0
 * @property Categories $category0
 */
class DealerCompanyPreferences extends ActiveRecord
{
    // Disabeling Behaviours
    public function behaviors(){
        return [];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dealer_company_preferences}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dc_id', 'category'], 'required'],
            [['dc_id', 'brand', 'category'], 'integer'],
            ['dc_id' , 'auction\models\validators\DealerPrefeneces']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dc_id' => 'Dc ID',
            'brand' => 'Brand',
            'category' => 'Category',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDc()
    {
        return $this->hasOne(DealerCompany::className(), ['id' => 'dc_id']);
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

    public static function primaryKey(){
        return ['dc_id','brand','category'];
    }

    public function addPreference($post){
        $this->brand = ArrayHelper::getValue($post , 'brand');
        $this->category = ArrayHelper::getValue($post , 'category');
        $this->dc_id = ArrayHelper::getValue($post , 'dc_id');

        if($this->save()){
            return true;
        }else{
            return false;
        }
    }
}