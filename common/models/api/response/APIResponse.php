<?php
/**
 * Created by PhpStorm.
 * User: XPS
 * Date: 6/1/2015
 * Time: 6:14 PM
 */
namespace common\models\api\response;

use Yii;
use yii\base\Model;

abstract class APIResponse extends Model {
    public $_v = 0;
    public $_time = null;
    //------------------------------------------------------------------------------------------------------------------
    public function fields(){
        $responseFields = $this->responseFields();
        return $this->doMasking($responseFields);
    }
    //------------------------------------------------------------------------------------------------------------------
    public function getErrorFields(){
        $responseFields = $this->getErrors();
        return $this->doMasking($responseFields);
    }
    //------------------------------------------------------------------------------------------------------------------
    private function doMasking($fields){
        $fieldMasks = $this->fieldMasks();
        $allFields = parent::fields();
        if(!is_array($fields) || count($fields) == 0){
            $fields = $allFields;
        }
        if(!is_array($fieldMasks) || count($fieldMasks) == 0){
            return $fields;
        }
        $fieldMasks = array_merge($allFields,$fieldMasks);
        $_fields = [];
        foreach($fields as $key=>$value){
            $_key = $key;
            if(!is_string($key) && is_string($value)){
                $_key = $value;
            }
            if(isset($fieldMasks[$_key])){
                $_key = $fieldMasks[$_key];
            }
            $_fields[$_key] = $value;
        }
        return $_fields;
    }
    //------------------------------------------------------------------------------------------------------------------
    public function fieldMasks(){
        return [];
    }
    //------------------------------------------------------------------------------------------------------------------
    public function responseFields(){
        return [];
    }
    //------------------------------------------------------------------------------------------------------------------
    public function setVersion($version){
        $this->_v = $version;
    }
    //------------------------------------------------------------------------------------------------------------------
    public function getArrayValue($array,$key,$default = null){
        if(!isset($array[$key])){
            return $default;
        }
        return $array[$key];
    }
}