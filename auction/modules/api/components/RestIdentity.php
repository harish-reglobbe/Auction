<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 7/8/15
 * Time: 5:28 PM
 */

namespace auction\modules\api\components;

use yii\filters\RateLimitInterface;
use yii\web\IdentityInterface;

class RestIdentity implements IdentityInterface,RateLimitInterface {


    public static function findIdentity($id){

    }

    //TODO Need to be Defined
    public static function findIdentityByAccessToken($token, $type = null){

        return __CLASS__;

    }


    public function getId(){}


    public function getAuthKey(){}


    public function validateAuthKey($authKey){}


    public function getRateLimit($request, $action){}


    public function loadAllowance($request, $action){}


    public function saveAllowance($request, $action, $allowance, $timestamp){}

}