<?php

use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use yii\grid\GridView;
use auction\components\Auction;
use yii\widgets\Pjax;
use auction\widgets\PageSize;
use auction\components\helpers\DatabaseHelper;
use auction\widgets\ModelCrud;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel auction\models\forms\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Company: Users';
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Company Users</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    User Details
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <?php Pjax::begin(['id' => 'pjax-gridview','timeout' => false, 'enablePushState' => false,'options' => ['class' => 'dataTable_wrapper']])?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'filterSelector' => 'select[name="SearchUser[pageSize]"]',
                        'rowOptions'=>function ($model, $key, $index, $grid){
                                        $class=$index%2 ? 'info':'gradeA even';
            	                        return array('key'=>$key,'index'=>$index,'class'=>$class);
                        },
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'name',
                            'email:email',
                            'mobile',
                            [
                                'header' => 'Status',
                                'value' => function($model){
                                    return DatabaseHelper::GetStatus($model->is_active);
                                },
                                'filter' => Html::activeDropDownList($searchModel,'is_active',DatabaseHelper::Status(),['class' => 'form-control','prompt' => '-------']),
                            ],
                            [
                                'value' => function($model){
                                    return Auction::$app->formatter->asDate($model->created_at);
                                },
                                'filter' => DatePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'created_at',
                                    'template' => '{addon}{input}',
                                    'clientOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy-mm-dd',
                                        'disableEntry'=>true,
                                    ],
                                    'options' => [
                                        'data-pjax' => false
                                    ]
                                ])
                            ],

                            [
                                'class' => 'auction\components\helpers\ActionColumn',
                            ],
                        ],
                        'options' => [
                            'class' => 'table table-striped table-bordered table-hover',
                            'id' => 'dataTables-example'
                        ]
                    ]); ?>

                    <?= PageSize::widget([
                        'model' => $searchModel,
                        'attribute' => 'pageSize',
                        'options' => [
                            'data-pjax' => '0',
                        ],
                    ]); ?>

                    <?php Pjax::end();?>
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

<?= ModelCrud::widget([
    'deleteUrl' => Url::to(['delete']),
    'updateUrl' => Url::to(['update']),
    'createUrl' => Url::to(['create']),
    'deleteVerb'  => 'post',
    'updateVerb' => 'post',
    'viewUrl' => Url::to(['view']),
    'viewVerb' => 'post',
    'createVerb' => 'post',
    'modelTitle' => 'User Profile'
]); ?>

<?php
$this->registerJs('
    jQuery(document).on("pjax:success", "#brand-form",  function(event){$.pjax.reload({container:"#pjax-gridview",timeout:2e3}),$("#activity-modal").modal("hide")});
    jQuery(document).pjax("#brand-form a", "#brand-form", {"push":false,"replace":false,"timeout":false,"scrollTo":false});
    jQuery(document).on("submit", "#brand-form form[data-pjax]", function (event) {jQuery.pjax.submit(event, "#brand-form", {"push":false,"replace":false,"timeout":false,"scrollTo":false});});
    ');
?>
