<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 28/8/15
 * Time: 2:54 PM
 */

namespace auction\widgets;

use yii\widgets\Pjax;
use yii\helpers\Url;

class GridView extends \yii\grid\GridView{

    public $is_pjax=true;
    public $pjaxOptions=['id' => 'pjax-gridview','timeout' => false, 'enablePushState' => false,'options' => ['class' => 'dataTable_wrapper']];

    public $summary = false;
    public $options=['class' => 'table table-striped table-bordered table-hover', 'id' => 'dataTables-example'];


    public $attribute='pageSize';
    public $modelTitle='Modal Window';

    public function init(){

        $this->rowOptions=function ($model, $key, $index, $grid){

            $class=$index%2 ? 'info':'';
            return array('key'=>$key,'index'=>$index,'class'=>$class);

        };

        $this->filterSelector = 'select[name="'. $this->filterModel->className() .'['. $this->attribute .']"]';

        parent::init();

    }

    public function run(){

        if($this->is_pjax){
            Pjax::begin($this->pjaxOptions);
        }

        parent::run();

        echo PageSize::widget([
            'model' => $this->filterModel,
            'attribute' => $this->attribute,
            'options' => [
                'data-pjax' => '0',
            ],
        ]);

        if($this->is_pjax){
            Pjax::end();
        }

        echo ModelCrud::widget([
            'updateUrl' => Url::to(['update']),
            'createUrl' => Url::to(['create']),
            'updateVerb' => 'post',
            'viewUrl' => Url::to(['view']),
            'viewVerb' => 'post',
            'createVerb' => 'post',
            'modelTitle' => $this->modelTitle,
            'template' => '{view}{update}{create}',
            'modelClass' =>  $this->dataProvider->query->modelClass
        ]);
    }

}