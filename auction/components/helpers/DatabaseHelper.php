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
    const SMS_TOKEN_VALID_TIME='+1 hour';

    const JAVA_API_PRODUCT_URL='http://192.168.1.111:8080/api/product.json';
    const JAVA_API_LOT_URL='http://192.168.1.111:8080/api/product/lot.json';

    const DEALER_REGISTRATION_TEMPLATE = 'dealer-registration-template';
    const COMPANY_REGISTRATION_TEMPLATE = 'company-registration-template';
    const FORGOT_PASSWORD_MAIL_TEMPLATE = 'forgot-password-mail-template';
    const FORGOT_PASSWORD_SMS_TEMPLATE = 'forgot-password-sms-template';

    const NEW_MAIL=0;
    const IN_QUEUE_MAIL=1;
    const SEND_MAIL=2;
    const FAILED_MAIL=3;
    const INVALID_MAIL=-1;

    const TOKEN_SEND_MODE_MOBILE = 0;
    const TOKEN_SEND_MODE_WEB = 1 ;

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

    public static function TemplateType(){
        return [
            0 => 'Email',
            1 => 'SMS'
        ];

        if($key){
            return self::KeyValue($key,$status);
        }
        else{
            return $status;
        }
    }

    public static function GetTemplateType($type){

        $statusValue='';
        $define_status=self::TemplateType();

        if(ArrayHelper::keyExists($type,$define_status)){
            $statusValue=ArrayHelper::getValue($define_status,$type);
        }

        return $statusValue;
    }

    public static function MailStatus($key=false){
        $status = [
            self::NEW_MAIL => 'New',
            self::IN_QUEUE_MAIL => 'In Queue',
            self::SEND_MAIL => 'Send',
            self::FAILED_MAIL => 'Failed',
            self::INVALID_MAIL => 'Invalid Data'
        ];

        if($key){
            return self::KeyValue($key,$status);
        }
        else{
            return $status;
        }
    }

    static function KeyValue($key,$array){
        $keyValue = '';

        if(ArrayHelper::keyExists($key,$array)){
            $keyValue=ArrayHelper::getValue($array,$key);
        }

        return $keyValue;
    }
}