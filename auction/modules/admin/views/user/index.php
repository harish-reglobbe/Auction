<?php

use yii\helpers\Html;
use yii\grid\GridView;
use auction\components\helpers\DatabaseHelper;
use yii\widgets\Pjax;
use auction\widgets\PageSize;
use dosamigos\datepicker\DatePicker;
use auction\components\Auction;
use auction\widgets\ModelCrud;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel auction\models\forms\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Users';
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Users</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <?php Pjax::begin(['id' => 'pjax-gridview','timeout' => false, 'enablePushState' => false,'options' => ['class' => 'dataTable_wrapper']])?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'filterSelector' => 'select[name="SearchCategory[pageSize]"]',
                        'rowOptions'=>function ($model, $key, $index, $grid){
                            $class=$index%2 ? 'info':'';
                            return array('key'=>$key,'index'=>$index,'class'=>$class);
                        },
                        'columns' => [
                            'name',
                            'email:email',
                            'mobile',
                            [
                                'header' => 'User Role',
                                'value' => 'user_role',
                                'filter' => Html::activeDropDownList($searchModel,'user_role',DatabaseHelper::UserRole(),['class' => 'form-control','prompt' => '-------']),
                            ],
                            [
                                'header' => 'Status',
                                'value' => function($model){
                                    return DatabaseHelper::GetStatus($model->is_active);
                                },
                                'filter' => Html::activeDropDownList($searchModel,'is_active',DatabaseHelper::Status(),['class' => 'form-control','prompt' => '-------']),
                            ],
                            [
                                'header' => 'Create Date',
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
                                'template' => '{view}{delete}'
                            ],
                        ],
                        'summary' => false,
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
    'viewUrl' => Url::to(['view']),
    'deleteVerb'  => 'post',
    'viewVerb' => 'post',
    'template' => '{view}{delete}',
]); ?>