<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%company_users}}".
 *
 * @property integer $company
 * @property integer $user
 *
 * @property Users $user0
 * @property Companies $company0
 */
class CompanyUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company_users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company', 'user'], 'required'],
            [['company', 'user'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company' => 'Company',
            'user' => 'User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(Users::className(), ['id' => 'user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany0()
    {
        return $this->hasOne(Companies::className(), ['id' => 'company']);
    }
}
