<?php

namespace auction\widgets\form;

use yii\helpers\BaseHtml;
use yii\helpers\Html;

class MultipleInsertField extends \yii\base\Widget{


    public $model;

    public $attribute;

    public $name='pro_conf_param';

    public $options = ['class' => 'form-control config-params'];

    public function init(){
        parent::init();
    }

    public function run(){

        $this->registerJs();

        return '<h5><a href="#" id="addScnt">Add Another Params</a></h5>
                <div id="p_scents"><p><label for="p_scnts">
                '. $this->renderTextBox() .'
                </label></p></div>';

    }

    private function registerJs(){
        $this->view->registerJs('
            $(function(){var e=$("#p_scents"),n=$("#p_scents p").size()+1;
            jQuery(document).on("click","#addScnt",function()
            {return $(\'<p><label for="p_scnts">'. $this->renderTextBox() .'</label> <a href="#" class="remScnt">Remove</a></p>\').appendTo(e),n++,!1}),
            jQuery(document).on("click",".remScnt",function(){return n>2&&($(this).parents("p").remove(),n--),!1})});
            ');
    }

    private function renderTextBox(){
        return Html::activeTextInput($this->model , $this->attribute,['name' => BaseHtml::getInputName($this->model , $this->attribute).'[]', 'class' => $this->options['class']]);
    }
}