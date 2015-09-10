<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 10/9/15
 * Time: 12:13 PM
 */

namespace auction\models\core;


use auction\components\Auction;

class ActiveRecord extends \yii\db\ActiveRecord{

    public static function model(){
        return Auction::createObject(['class' => self::className()]);
    }

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

    public function afterSave($insert, $changedAttributes){

        if($this->isNewRecord){
            Auction::infoLog('Model record :: '. self::className() .' Has Successfully Saved',$this->getAttributes());
            return true;
        }else{
            Auction::infoLog('Model record :: '. self::className() .' Has Successfully updated ',$this->getAttributes());
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
}