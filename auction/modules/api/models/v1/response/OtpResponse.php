<?php

namespace auction\modules\api\models\v1\response;
use auction\components\api\ApiResponse;

/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 28/8/15
 * Time: 12:28 PM
 */

class OtpResponse extends ApiResponse{

    public $success;

    public function rules(){
        return [
            ['success' ,'in', 'range' => [0, 1]]
        ];
    }

    public function attributeLabels(){
        return [
            "success" => "success",
        ];
    }
    //------------------------------------------------------------------------------------------------------------------
    public function fieldMasks(){
        return [
            'success'=>'s',
            '_time' => 'pm',
        ];
    }
    //------------------------------------------------------------------------------------------------------------------
    public function responseFields(){
        return [
            'success' => 'success',
            '_time' => '_time',
        ];
    }
}