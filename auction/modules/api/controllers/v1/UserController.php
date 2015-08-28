<?php

namespace auction\modules\api\controllers\v1;

use auction\components\Auction;
use auction\modules\api\components\RestController;
use auction\modules\api\models\v1\request\OtpRequest;
use auction\modules\api\models\v1\response\OtpResponse;
use yii\helpers\Json;

class UserController extends RestController
{

    private $_getQueryParam;

    public function verbs(){
        return [
            'otp' => ['get']
        ];
    }

    public function init(){
        $this->setQueryParam();

        parent::init();
    }

    /**
     * Query Param Setter
     * Convert Response Query To Object
     */
    public function setQueryParam(){
        $this->_getQueryParam = new \stdClass();
        $request = Auction::$app->request->getQueryParams();

        foreach ($request as $key => $value)
        {
            $this->_getQueryParam->$key = $value;
        }

        Auction::info('Setting Query Parameters'.Json::encode($request).'::'.__METHOD__,'request');
    }

    /**
     * Query Param Getter
     * @return object getQueryParam
     */

    public function getQueryParam(){

        if($this->_getQueryParam === null){
            $this->setQueryParam();
        }

        return $this->_getQueryParam;
    }


    /**
     * @return array| $response object of OTP action
     *
     * @require param mob
     *
     * json value format {"s":10,"pm":2.8347969055176}
     *
     */
    public function actionOtp(){

        $request = new OtpRequest();
        $request->mobile = $this->QueryParam->mob;

        if(!$request->validate()){
            return $this->sendResponseError(403);
        }

        $response = new OtpResponse();
        $response->success=10;

        return $this->sendResponse($response,false);


    }

}
