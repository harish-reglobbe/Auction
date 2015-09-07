<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 7/9/15
 * Time: 4:51 PM
 */

class CombineUniqueValidator extends \yii\validators\Validator{

    public $attributes;

    public function validateAttribute($model, $attribute){

        if(is_string($this->attributes)){

        }

    }

}