<?php
/**
 * Created by PhpStorm.
 * User: Double H
 * Date: 19-08-2015
 * Time: 09:01 PM
 */

namespace auction\widgets\grid;
use auction\models\MessageTemplate;
use yii\base\Widget;
use yii\web\HttpException;
use yii\web\JsExpression;
use yii\bootstrap\Modal;
use yii\helpers\Html;

class ModelCrud extends Widget
{

//    public $deleteUrl;
    public $updateUrl;
    public $createUrl;
    public $viewUrl;

//    public $deleteVerb='get';
    public $viewVerb='get';
    public $createVerb='get';
    public $updateVerb='get';

    public $updateModalSelector='.update-modal';
//    public $deleteModelSelector='.delete-modal';
    public $viewModalSelector='.view-modal';
    public $createModalSelector='#create-modal';

    public $pjaxContainerId='pjax-gridview';

//    public $deleteModelTitle='Delete';
    public $template='{view}{delete}{update}{create}';
    public $modelTitle='Model';
    public $modelClass;

    private $_renderJs;

    public function init(){
        if(!$this->updateUrl || !$this->createUrl || !$this->viewUrl){
            throw new HttpException(400, 'Urls Must Be defined');
        }
    }

    public function run(){

        $this->registerJs();
        $output=$this->initializeModal();

        return $output;
    }

    private function registerJs(){
        $view=$this->view;

        preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches){
            $name = $matches[1];
            $this->appendJs($name);
        },$this->template);

        $view->registerJs(substr($this->_renderJs,0,-1));
    }

    private function initializeModal(){

        Modal::begin([
            'id' => 'activity-modal',
            'header' => '<h2>'. $this->modelTitle .'</h2>',
            'footer' => Html::button('Close', ['class' => 'btn btn-info', 'data-dismiss' => 'modal']),
        ]);

        Modal::end();

//        Modal::begin([
//            'id' => 'activity-delete-modal',
//            'header' => '<h2>'. $this->deleteModelTitle .'</h2>',
//            'footer' => Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal'])
//                . PHP_EOL . Html::button('Delete', [
//                    'class' => 'btn btn-primary btn-modal-save',
//                    'id' => 'delete-role-model',
//                    'data-id' => '',
//                    'onClick' => new JsExpression('var id=$("#delete-role-model").attr("data-id");$.ajax({type:"'. $this->deleteVerb .'",url:"'.$this->deleteUrl.'",data:{id:id},success:function(){$.pjax.reload({container:"#'. $this->pjaxContainerId .'",timeout:2e3}),$("#activity-delete-modal").modal("hide")}});')
//                ]),
//        ]);
//        echo 'Are You Sure To Delete This Item';
//        Modal::end();

    }

    private function updateModalJs(){
        return 'jQuery(document).on("click","'. $this->updateModalSelector .'",function(){var t=$(this).attr("data-id");$.ajax({type:"'. $this->updateVerb .'",url:"'.$this->updateUrl.'",data:{id:t},success:function(t){$("#activity-modal").find(".modal-body").html(t),$("#activity-modal").modal("show")}})})';
    }

    private function viewModalJs(){
        return 'jQuery(document).on("click","'.$this->viewModalSelector.'",function(){var t=$(this).attr("data-id");$.ajax({type:"'.$this->viewVerb.'",url:"'.$this->viewUrl.'",data:{id:t},success:function(t){$("#activity-modal").find(".modal-body").html(t),$("#activity-modal").modal("show")}})})';
    }

    private function createModalJs(){
        return 'jQuery(document).on("click","'.$this->createModalSelector.'",function(){$.ajax({type:"'. $this->createVerb .'",url:"'.$this->createUrl.'",success:function(t){$("#activity-modal").find(".modal-body").html(t),$("#activity-modal").modal("show")}})})';
    }

//    private function deleteModalJs(){
//        return 'jQuery(document).on("click","'.$this->deleteModelSelector.'",function(){var t=$(this).attr("data-id");$("#delete-role-model").attr("data-id",t),$("#activity-delete-modal").modal("show")})';
//    }

    private function appendJs($name){
        switch ($name) {
            case "view":
                $this->_renderJs.=$this->viewModalJs().',';
                break;
            case "update":
                $this->_renderJs.=$this->updateModalJs().',';
                break;
//            case "delete":
//                $this->_renderJs.=$this->deleteModalJs().',';
//                break;
            case "create":
                $this->_renderJs.=$this->createModalJs().',';
                break;
            default:
                return ;
        }
    }
}