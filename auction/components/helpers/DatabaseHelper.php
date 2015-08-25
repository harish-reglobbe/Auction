<?php
/**
 * Created by PhpStorm.
 * User: Double H
 * Date: 22-08-2015
 * Time: 09:30 AM
 */

namespace auction\components\helpers;


use yii\helpers\ArrayHelper;

class DatabaseHelper
{

    const ADMIN='ADMIN';
    const COMPANY_ADMIN='COMPANY_ADMIN';
    const COMPANY_USER='COMPANY_USER';
    const DEALER='DEALER';

    const ACTIVE=1;
    const IN_ACTIVE=0;

    const EMAIL_TOKEN_VALID_TIME='+ 24 hour';
    const SMS_TOKEN_VALID_TIME= '+1 hour';

    public static function UserRole($isShownAdmin=false){

        $roles=[
            self::COMPANY_ADMIN => 'Company Admin',
            self::COMPANY_USER => 'Company User',
            self::DEALER => 'Dealer'
        ];

        if($isShownAdmin){
            $roles=ArrayHelper::merge($roles,[self::ADMIN => 'Admin']);
        }

        return $roles;
    }

    public static function Status(){

        $status=[
            self::ACTIVE => 'Active',
            self::IN_ACTIVE => 'In-Active'
        ];

        return $status;
    }

    public static function GetStatus($status){

        $statusValue='';
        $define_status=self::Status();

        if(ArrayHelper::keyExists($status,$define_status)){
            $statusValue=ArrayHelper::getValue($define_status,$status);
        }

        return $statusValue;
    }

    public static function TokenSendingOption(){

        return [
            'email' =>'Email',
            'sms' => 'SMS'
        ];
    }

}