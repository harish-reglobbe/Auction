<?php

namespace auction\models;

use auction\models\core\ActiveRecord;
use auction\models\core\TimestampBehaviour;

/**
 * This is the model class for table "product_config".
 *
 * @property integer $id
 * @property string $name
 * @property integer $company
 * @property integer $cat_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ProdConfName[] $prodConfNames
 * @property Companies $company0
 * @property Categories $cat
 */
class ProductConfig extends ActiveRecord
{

    public function behaviors()
    {
        return [
            TimestampBehaviour::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'company','brand_id', 'cat_id'], 'required'],
            [['company', 'cat_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255]
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
            'company' => 'Company',
            'cat_id' => 'Cat ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProdConfNames()
    {
        return $this->hasMany(ProdConfName::className(), ['pro_conf_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany0()
    {
        return $this->hasOne(Companies::className(), ['id' => 'company']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Categories::className(), ['id' => 'cat_id']);
    }

    public function getBrand(){
        return $this->hasOne(Brands::className(), ['id' => 'brand_id']);
    }
}
