<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%companies}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $domain
 * @property string $contact
 * @property string $create_date
 * @property string $update_date
 * @property string $description
 * @property string $image
 * @property integer $is_active
 *
 * @property Auctions[] $auctions
 * @property CompanyUsers[] $companyUsers
 * @property DealerCompany[] $dealerCompanies
 */
class Companies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%companies}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'domain', 'contact', 'create_date', 'image', 'is_active'], 'required'],
            [['create_date', 'update_date'], 'safe'],
            [['description'], 'string'],
            [['is_active'], 'integer'],
            [['name', 'domain', 'image'], 'string', 'max' => 255],
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
            'domain' => 'Domain',
            'contact' => 'Contact',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
            'description' => 'Description',
            'image' => 'Image',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuctions()
    {
        return $this->hasMany(Auctions::className(), ['company' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyUsers()
    {
        return $this->hasMany(CompanyUsers::className(), ['company' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealerCompanies()
    {
        return $this->hasMany(DealerCompany::className(), ['company' => 'id']);
    }
}
