<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 10/9/15
 * Time: 12:13 PM
 *
 *
 * Active Record Class for Auctions models
 */

namespace auction\models\core;


use auction\components\Auction;

class ActiveRecord extends \yii\db\ActiveRecord{

    /**
     * @return object
     *
     * model can be accessed as Model::model()->function();
     * In Yii 1  Manner as statically
     *
     * @throws \yii\base\InvalidConfigException
     */
    public static function model(){
        return Auction::createObject(['class' => self::className()]);
    }

    /**
     *
     *
     * @return array behaviours
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehaviour::className(),
                'createdAtAttribute' => 'create_date',
                'updatedAtAttribute' => 'update_date',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function beforeSave($insert){

        if(parent::beforeSave($insert)){

            if($this->isNewRecord){
                Auction::infoLog('Model record :: '. self::className() .' Has Successfully Saved',$this->getAttributes());
            }else{
                Auction::infoLog('Model record :: '. self::className() .' Has Successfully updated ',$this->getAttributes());
            }

            return true;

        }else{
            return false;
        }

    }

    public function validate($attributeNames = null, $clearErrors = true){

        if(parent::validate($attributeNames, $clearErrors)){
            Auction::infoLog('Model :: ' . self::className() . ' Has Successfully Validated ', $this->getAttributes());
            return true;
        }else{
            Auction::errorLog('Model record :: '. self::className() .' not validated ',$this->getErrors());
            return false;
        }
    }

    public function afterDelete(){

        Auction::warningLog('Model :: ' . self::className() . ' Has Been Deleted ', $this->getAttributes());
        return parent::afterDelete();
    }
}