<?php
/**
 * Created by PhpStorm.
 * User: Double H
 * Date: 05-09-2015
 * Time: 03:35 PM
 */

namespace auction\models\validators;

use auction\models\Users;
use yii\validators\EmailValidator;
use yii\validators\NumberValidator;
use yii\validators\Validator;

class UserValidator extends Validator
{
    public $attributes = 'username';
    public $user;

    public function validateAttribute($model, $attribute) {
        switch ($model->via){
            case 'email':
                $this->validateAsEmail($model,$attribute);
                break;

            case 'sms':
                $this->validateAsNumber($model,$attribute);
                break;

            default:
                $model->addError('via' , 'Please Select atleast one option');
        }

        if(!$model->hasErrors()){
            if(!$this->findUser($model,$attribute))
                $model->addError('username', 'Not Registered');
        }

    }

    private function validateAsEmail($model,$attribute){

        $validator = new EmailValidator();

        if(!$validator->validate($model->$attribute)){
            $model->addError('username' ,'Must Be a valid Email');
        }

    }

    private function validateAsNumber($model,$attribute){
        $validator = new NumberValidator();

        if(!$validator->validate($model->$attribute, $error)){
            $model->addError('username' ,'Must be a Valid Number');
        }
    }

    private function findUser($model,$attribute){
        $this->user =  Users::findByUsername($model->$attribute , false);
        return $this->user;
    }
}