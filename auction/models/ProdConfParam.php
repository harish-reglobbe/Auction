<?php

namespace auction\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "prod_conf_param".
 *
 * @property integer $id
 * @property string $name
 * @property integer $p_conf_n_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ProdConfName $pConfN
 */
class ProdConfParam extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prod_conf_param';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'p_conf_n_id',], 'required'],
            [['p_conf_n_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['name' , 'CheckValueExist']
        ];
    }

    public function CheckValueExist($attributes,$params){
        $model = self::find()->where([
            'name' => $this->name,
            'p_conf_n_id' => $this->p_conf_n_id
        ])->one();

        if($model !== null){
            $this->addError('name','Alreay Exist');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'p_conf_n_id' => 'P Conf N ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPConfN()
    {
        return $this->hasOne(ProdConfName::className(), ['id' => 'p_conf_n_id']);
    }
}
