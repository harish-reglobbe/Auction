<?php

use yii\helpers\Html;
use auction\widgets\GridView;
use auction\widgets\ModelCrud;
use yii\helpers\Url;

$this->title = 'Templates';
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Products</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button class="btn btn-info" type="button" id="create-modal">+ Add More Products</button>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [

                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'header' => 'Select To Delete'
                            ],
                            'name',
                            [
                                'header' => 'Product Image',
                                'filter' => false,
                                'format' => 'raw',
                                'value' => function($model){
                                    return Html::img($model->image);
                                }
                            ],
                            [
                                'header' => 'Brand',
                                'value' => 'brand0.name'
                            ],
                            [
                                'header' => 'Catgory',
                                'value' => 'category0.name'
                            ],
                            [
                                'header' => 'Lot',
                                'value' => 'lot0.name'
                            ],
                            'prize',
                            'condition',

                            [
                                'class' => 'auction\components\helpers\ActionColumn',
                                'template' => '{view}{update}{create}'
                            ],
                        ],
                    ]); ?>

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<?=ModelCrud::widget([
    'deleteUrl' => Url::to(['delete']),
    'updateUrl' => Url::to(['update']),
    'createUrl' => Url::to(['create']),
    'viewUrl' => Url::to(['view']),
    'pjaxContainerId' => 'pjax-gridview',
    'deleteVerb' => 'post'
]);
?>
<?php $this->registerJs('jQuery(document).on("click","#delete-selected-products",function(){var e=$("#products-grid").yiiGridView("getSelectedRows");return $.ajax({type:"post",url:"'.Url::to(['delete']).'",data:{id:e},success:function(){$.pjax.reload({container:"#pjax-gridview",timeout:2e3})}}),!1});');?>
