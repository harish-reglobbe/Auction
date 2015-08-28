<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 27/8/15
 * Time: 6:31 PM
 */

namespace auction\components\api;
use auction\components\Auction;
use yii\helpers\Json;

class ApiRequest extends \common\models\api\request\APIRequest{

    const LOGGER_CATEGORY = 'request';

    public function loadFromRequest(){

    }

    public function validate($attributeNames = null, $clearErrors = true){

        if(parent::validate($attributeNames, $clearErrors)){
            Auction::info('Successfully Validated Request::::::'. $this->loggerMessage(),self::LOGGER_CATEGORY);
            return true;

        }else {
            Auction::error('Request Not Validated::::::::'. $this->loggerMessage(),self::LOGGER_CATEGORY);
            return false;
        }

    }

    private function loggerMessage(){

        return Json::encode([
            array($this)
        ]). ':::::class::::'.self::className().'::::::method::::::::'.__METHOD__;
    }
}