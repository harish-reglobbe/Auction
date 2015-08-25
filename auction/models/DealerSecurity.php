<?php

namespace auction\models;

use Yii;

/**
 * This is the model class for table "{{%dealer_security}}".
 *
 * @property integer $id
 * @property double $security
 * @property integer $dealer
 * @property string $create_date
 * @property string $update_date
 *
 * @property Dealers $dealer0
 * @property DealerSecurityConsume[] $dealerSecurityConsumes
 */
class DealerSecurity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dealer_security}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['security'], 'number'],
            [['dealer', 'create_date'], 'required'],
            [['dealer'], 'integer'],
            [['create_date', 'update_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'security' => 'Security',
            'dealer' => 'Dealer',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
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
    public function getDealerSecurityConsumes()
    {
        return $this->hasMany(DealerSecurityConsume::className(), ['security' => 'id']);
    }
}
