<?php

namespace auction\models;


use auction\components\Auction;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\Query;

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
 * @property string $address
 * @property string $logo_image
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
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_date',
                'updatedAtAttribute' => 'update_date',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'domain', 'contact', 'create_date', 'address', 'logo_image', 'is_active'], 'required'],
            [['create_date', 'update_date'], 'safe'],
            [['description', 'address'], 'string'],
            [['is_active'], 'integer'],
            [['name', 'domain', 'logo_image'], 'string', 'max' => 255],
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
            'address' => 'Address',
            'logo_image' => 'logo image',
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

    public function getUser(){
        return $this->hasOne(Users::className(),['id' => 'user'])->viaTable(CompanyUsers::tableName(),['company' => 'id']);
    }

    //Company Details having count all auctions and users and dealers
    public function getCompanyDetails(){

        return (new Query())->select(
            '('.(new Query())->select('count(*)')->from(Auctions::tableName())->where(['company' => $this->id])->createCommand()->rawSql.') as companyAuctions,'.
            '('.(new Query())->select('count(*)')->from(CompanyUsers::tableName())->where('company=:c and user!=:u',[':c' => $this->id , ':u' => Auction::$app->user->id])->createCommand()->rawSql.') as companyUsers,'.
            '('.(new Query())->select('count(*)')->from(DealerCompany::tableName())->where(['company' => $this->id])->createCommand()->rawSql.') as companyDealers'
        )->one();

    }
}
