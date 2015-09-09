<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 9/9/15
 * Time: 10:17 AM
 */

namespace auction\models\validators;


use auction\models\DealerPreference;
use yii\validators\Validator;

class DealerPrefeneces extends Validator{

    public $attribute = 'dealer';

    public function validateAttribute($model,$attribute){

        $_model = $model->find()->where([
            'brand' => $model->brand,
            'category' => $model->category,
            $attribute => $model->$attribute
        ])->one();

        if($_model){
            $model->addError('dealer' , 'Already Added Prefeneces');
        }
    }

}