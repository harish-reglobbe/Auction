<?php

namespace auction\models;

use Yii;

/**
 * This is the model class for table "{{%dealers}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $city
 * @property string $contact
 * @property string $address
 * @property integer $user
 *
 * @property DealerAuctions[] $dealerAuctions
 * @property DealerCompany[] $dealerCompanies
 * @property DealerPreference[] $dealerPreferences
 * @property DealerSecurity[] $dealerSecurities
 * @property Users $user0
 */
class Dealers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dealers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'city', 'contact', 'address', 'user'], 'required'],
            [['address'], 'string'],
            [['user'], 'integer'],
            [['name', 'city'], 'string', 'max' => 255],
            [['contact'], 'string', 'max' => 15]
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
            'city' => 'City',
            'contact' => 'Contact',
            'address' => 'Address',
            'user' => 'User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealerAuctions()
    {
        return $this->hasMany(DealerAuctions::className(), ['dealer' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealerCompanies()
    {
        return $this->hasMany(DealerCompany::className(), ['dealer' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealerPreferences()
    {
        return $this->hasMany(DealerPreference::className(), ['dealer' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealerSecurities()
    {
        return $this->hasMany(DealerSecurity::className(), ['dealer' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(Users::className(), ['id' => 'user']);
    }
}
