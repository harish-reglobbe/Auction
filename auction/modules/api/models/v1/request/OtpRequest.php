<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 28/8/15
 * Time: 10:40 AM
 */

namespace auction\modules\api\models\v1\request;

use auction\components\api\ApiRequest;

class OtpRequest extends ApiRequest{

    public $mobile;

    public function rules(){
        return [
            ['mobile' , 'required'],
            ['mobile' , 'number' ],
        ];
    }

    public function attributeLabels(){
        return [
            'mobile' => 'Mobile No.'
        ];
    }

}