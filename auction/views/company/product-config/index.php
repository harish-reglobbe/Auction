<?php

use auction\widgets\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel auction\models\forms\SearchBrand */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title='Product Config';
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Product Config Excel Format</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <button class="btn btn-info" type="button" id="create-modal">+ Add More Product Config Format</button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'name',
                        [
                            'class' => 'auction\widgets\grid\DatePickerColumn',
                            'dateColumn' => 'created_at'
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update}',
                        ],
                        [
                            'format' => 'raw',
                            'value' => function($model){
                                return Html::a('<i class="fa fa-download"></i>',\yii\helpers\Url::to(['download-csv','id' => $model->primaryKey]),[
                                    'class' => 'btn btn-default download-csv' ,
                                    'id' => $model->primaryKey,
                                    'data-pjax' => '0'
                                ]);
                            }
                        ]
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
<?php
$this->registerJs('
    jQuery(document).on("pjax:success", "#brand-form",  function(event){$.pjax.reload({container:"#pjax-gridview",timeout:2e3}),$("#activity-modal").modal("hide")});
    jQuery(document).pjax("#brand-form a", "#brand-form", {"push":false,"replace":false,"timeout":false,"scrollTo":false});
    jQuery(document).on("submit", "#brand-form form[data-pjax]", function (event) {jQuery.pjax.submit(event, "#brand-form", {"push":false,"replace":false,"timeout":false,"scrollTo":false});});

    ');
?>
