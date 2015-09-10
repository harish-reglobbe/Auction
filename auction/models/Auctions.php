<?php

namespace auction\models;

use auction\models\core\ActiveRecord;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "{{%auctions}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $create_date
 * @property string $start_date
 * @property integer $duration
 * @property double $amount
 * @property integer $company
 * @property integer $status
 * @property integer $priority
 *
 * @property AuctionPreference[] $auctionPreferences
 * @property Companies $company0
 * @property AuctionsCriteria[] $auctionsCriterias
 * @property BidsTerm[] $bidsTerms
 * @property DealerAuctions[] $dealerAuctions
 * @property DealerSecurityConsume[] $dealerSecurityConsumes
 * @property Lots[] $lots
 */
class Auctions extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auctions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'create_date', 'start_date', 'duration', 'company', 'status'], 'required'],
            [['create_date', 'start_date'], 'safe'],
            [['duration', 'company', 'status', 'priority'], 'integer'],
            [['amount'], 'number'],
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
            'name' => 'Auction Name',
            'create_date' => 'Create Date',
            'start_date' => 'Start Date',
            'duration' => 'Duration Time',
            'amount' => 'Amount',
            'company' => 'Company',
            'status' => 'Status',
            'priority' => 'Priority',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuctionPreferences()
    {
        return $this->hasMany(AuctionPreference::className(), ['auction' => 'id']);
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
    public function getAuctionsCriterias()
    {
        return $this->hasOne(AuctionsCriteria::className(), ['auction' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBidsTerms()
    {
        return $this->hasOne(BidsTerm::className(), ['auction' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealerAuctions()
    {
        return $this->hasMany(DealerAuctions::className(), ['auction' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealerSecurityConsumes()
    {
        return $this->hasMany(DealerSecurityConsume::className(), ['auction' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLots()
    {
        $query =  Lots::find()->where([
            'auction' => $this->id
        ])->limit(3);

        return new ActiveDataProvider([
            'query' => $query
        ]);
    }

    /**
     * @param $id company Id whose Auctions to be retured
     * @return activedataprovider instance
     * limit is setted as 3
     */
    public static function latestCompanyAuction($id){

        $query =  self::find()->where([
            'company' => $id
        ])->limit(3);

        return new ActiveDataProvider([
            'query' => $query
        ]);
    }
}
