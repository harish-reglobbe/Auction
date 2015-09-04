<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 3/9/15
 * Time: 5:34 PM
 */

namespace auction\widgets\jui;

use yii\web\JsExpression;
use yii\helpers\Json;

class AutoComplete extends \yii\jui\AutoComplete{

    /**
     * echo AutoComplete::widget([
    'name' => 'country',
    'id' => 'name_search',
    'clientOptions' => [
    'source' => Auction::createUrl('dealer/companies/list-companies'),
    'minLength' => '1', // min chars to start search
    'select' =>  new JsExpression('function(event, data) {
    $("#name_search").val(data.item.value);
    $(this).data("id",data.item.id);
    return false;}'),
    'focus' => new JsExpression("function(event,data){
    $(this).val(data.item.value);
    return false;}")
    ],
    'options' => [
    'class' => 'form-control'
    ]
     */


    public $url;

    public $renderItem;

    public function init(){

        $this->clientOptions =[
            'source' => $this->url,
            'minLength' => 1,
            'select' => new JsExpression('function(event, data) {$("#'.$this->id.'").val(data.item.name);$(this).data("id",data.item.id);return false;}'),
            'focus' => new JsExpression('function(event,data){$(this).val(data.item.name);return false;}'),
        ];

        $this->renderItem = new JsExpression('.autocomplete("instance")._renderItem = function( ul, item ) {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<a>" + item.name + "<br><img src =" + "http://localhost/Auction/auction/web/uploads/products/thumbs/index1441177480.jpeg" + "></img></a>")
                    .appendTo(ul);
                };'
        );

        parent::init();

    }

    private function registerCss(){

    }

    protected function registerClientOptions($name, $id)
    {
        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '' : Json::htmlEncode($this->clientOptions);
            $js = "jQuery('#$id').$name($options)".$this->renderItem;
            $this->getView()->registerJs($js);
        }
    }

}