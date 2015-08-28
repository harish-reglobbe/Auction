<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 27/8/15
 * Time: 6:32 PM
 */

namespace auction\components\api;
use auction\components\Auction;
use yii\helpers\Json;

class ApiResponse extends \common\models\api\response\APIResponse{

    const LOGGER_CATEGORY = 'response';


    public function validate($attributeNames = null, $clearErrors = true){

        if(parent::validate($attributeNames, $clearErrors)){
            Auction::info('Successfully Validated Response::::::'. $this->loggerMessage(),self::LOGGER_CATEGORY);
            return true;

        }else {
            Auction::error('Response Not Validated::::::::'. $this->loggerMessage(),self::LOGGER_CATEGORY);
            return false;
        }

    }

    private function loggerMessage(){

        return Json::encode([
            array($this)
        ]). ':::::class::::'.self::className().'::::::method::::::::'.__METHOD__;
    }

}