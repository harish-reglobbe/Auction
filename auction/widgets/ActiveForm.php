<?php
/**
 * Created by PhpStorm.
 * User: Double H
 * Date: 12-09-2015
 * Time: 04:10 PM
 */

namespace auction\widgets;


class ActiveForm extends \yii\widgets\ActiveForm
{
    public $fieldClass = 'auction\widgets\ActiveField';

    public $successCssClass = false;

}