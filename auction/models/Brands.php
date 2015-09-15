<?php

namespace auction\models;

use auction\components\Auction;
use auction\models\core\ActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use auction\components\Events;
use auction\components\EventHandler;

/**
 * This is the model class for table "{{%brands}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property string $create_date
 * @property string $update_date
 * @property integer $is_active
 *
 * @property AuctionPreference[] $auctionPreferences
 * @property DealerCompanyPreferences[] $dealerCompanyPreferences
 * @property DealerPreference[] $dealerPreferences
 * @property LotPreference[] $lotPreferences
 * @property Products[] $products
 */
class Brands extends ActiveRecord
{
    /**
     * @inheritdoc
     */

    public function behaviors(){

    }

    private $_uploadDirectory;

    public static function tableName()
    {
        return '{{%brands}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name',], 'required'],
            [['description'], 'string'],
            [['is_active'], 'integer'],
            ['name', 'unique']
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
            'description' => 'Description',
            'image' => 'Image',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
            'is_active' => 'Is Active',
        ];
    }

    public function init(){
        $this->on(Events::UPLOAD_IMAGE, [EventHandler::className(), 'UploadImage']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuctionPreferences()
    {
        return $this->hasMany(AuctionPreference::className(), ['brand' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealerCompanyPreferences()
    {
        return $this->hasMany(DealerCompanyPreferences::className(), ['brand' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealerPreferences()
    {
        return $this->hasMany(DealerPreference::className(), ['brand' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLotPreferences()
    {
        return $this->hasMany(LotPreference::className(), ['brand' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['brand' => 'id']);
    }


    public function save($runValidation = true, $attributeNames = null){

        $this->image=UploadedFile::getInstance($this,'image');

        if(!parent::validate())
            return false;

        if($this->image && $this->image instanceof UploadedFile){

            if(!getimagesize($this->image->tempName)){
                $this->addError('image','Please Upload a valid Image');
                return false;
            }
            $this->trigger(Events::UPLOAD_IMAGE);
        }
        else {
            if(!$this->isNewRecord){
                $this->image = ArrayHelper::getValue($this->oldAttributes , 'image');
            }
        }
        return parent::save(false);
    }



    public function UploadDirectory(){

        if($this->_uploadDirectory === null){
            $this->_uploadDirectory = Auction::getAlias('@webroot').'/uploads/brands/';
        }

        return $this->_uploadDirectory;
    }

}
