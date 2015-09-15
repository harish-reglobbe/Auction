<?php

namespace auction\models;

use auction\models\core\ActiveRecord;
use auction\models\core\Expression;
use auction\models\core\TimestampBehaviour;
use Yii;

/**
 * This is the model class for table "{{%prod_conf_name}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $pro_conf_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ProductConfig $proConf
 * @property ProdConfParam[] $prodConfParams
 */
class ProdConfName extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehaviour::className(),
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%prod_conf_name}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['pro_conf_id'], 'integer'],
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
            'pro_conf_id' => 'Pro Conf ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProConf()
    {
        return $this->hasOne(ProductConfig::className(), ['id' => 'pro_conf_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProdConfParams()
    {
        return $this->hasMany(ProdConfParam::className(), ['p_conf_n_id' => 'id']);
    }
}
