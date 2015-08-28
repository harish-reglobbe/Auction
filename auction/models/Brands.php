<?php

namespace auction\models;

use auction\components\Auction;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;

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
class Brands extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    private $_uploadDirectory;

    public static function tableName()
    {
        return '{{%brands}}';
    }

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
            [['name',], 'required'],
            [['description'], 'string'],
            [['is_active'], 'integer'],
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
        parent::validate();

        if($this->image instanceof UploadedFile){

            if(!getimagesize($this->image->tempName)){
                $this->addError('image','Please Upload a valid Image');
                return false;
            }

            $uploadDirectory= $this->UploadDirectory();

            if(!is_dir($uploadDirectory)){
                FileHelper::createDirectory($uploadDirectory);
            }

            $imageName=$this->image->baseName.time().'.'.$this->image->extension;

            $this->image->saveAs($uploadDirectory.$imageName);
            $this->image=$imageName;

        }

        return parent::save();

    }

    public function afterSave(){

        if($this->image !== null) {

            $uploadDirectory = $this->UploadDirectory();
            $thumbDirectory = $uploadDirectory.'thumbs/';

            if(!is_dir($thumbDirectory)){
                FileHelper::createDirectory($thumbDirectory);
            }

            Image::thumbnail($uploadDirectory .$this->image, 50, 50)
                ->save($thumbDirectory . $this->image, ['quality' => 50]);

        }
        return true;

    }


    private function UploadDirectory(){

        if($this->_uploadDirectory === null){
            $this->_uploadDirectory = Auction::getAlias('@webroot').'/uploads/brands/';
        }

        return $this->_uploadDirectory;

    }
}
