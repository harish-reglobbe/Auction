<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 4/9/15
 * Time: 3:42 PM
 */

namespace auction\models\forms;


use yii\base\Model;

class CreateProductConfig extends Model{

    public $typeName;

    public $name;

    public $cat_id;

    public $pro_conf_param;

    public function rules(){
        return [
            [['name','pro_conf_param','typeName'] , 'required'],
            ['pro_conf_param' , 'UniqueValues']
        ];
    }

    public function UniqueValues($attribute,$param){
        $_param= array_map('strtolower', $this->$attribute);

        if(count($_param) != count(array_unique($_param))){
            $this->addError('pro_conf_param', 'Must Contain Unique Params');
            $this->pro_conf_param = '';
        }
    }

    public function attributeLabels(){
        return[
            'type' => 'Configuration Type Name',
            'name' => 'Configuration Name',
            'cat_id' => 'Category Name',
            'pro_conf_param' => 'Configuration Param'
        ];
    }


    public function save(){
       if(!$this->validate()) {
           return false;
       }


    }
}