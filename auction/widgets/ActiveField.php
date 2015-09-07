<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 31/8/15
 * Time: 10:50 AM
 */

namespace auction\widgets;


use yii\helpers\ArrayHelper;

class ActiveField extends \yii\widgets\ActiveField{

    //Error Options For Active Field Error Tag
    public $errorOptions= ['class' => 'error', 'tag' => 'span'];

    public function init(){

        //Changing Input Options Merge with form-class
        $this->inputOptions = ['placeHolder' => $this->model->getAttributeLabel($this->attribute), 'class' => 'form-control'];

        parent::init();
    }

    /**
     * @param null $label Setting Label Value to false
     * @param array $options
     */
    public function label($label = null, $options = [])
    {

        $this->parts['{label}'] = '';

    }

}