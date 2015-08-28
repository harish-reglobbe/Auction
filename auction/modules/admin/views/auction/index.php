<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
use auction\components\helpers\DatabaseHelper;
use auction\components\Auction;
use auction\widgets\PageSize;
use auction\widgets\ModelCrud;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel auction\models\forms\SearchAuction */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auctions';
?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Auctions</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <?php Pjax::begin(['id' => 'pjax-gridview','timeout' => false, 'enablePushState' => false,'options' => ['class' => 'dataTable_wrapper']])?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'filterSelector' => 'select[name="SearchAuction[pageSize]"]',
                            'rowOptions'=>function ($model, $key, $index, $grid){
                                $class=$index%2 ? 'info':'';
                                return array('key'=>$key,'index'=>$index,'class'=>$class);
                            },
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                'name',
                                [
                                    'header' => 'Company Name',
                                    'value' => 'company0.name',
                                    'filter' => Html::activeTextInput($searchModel,'companyName',['class' => 'form-control'])
                                ],
                                'amount',
                                [
                                    'header' => 'Status',
                                    'value' => function($model){
                                        return DatabaseHelper::GetStatus($model->status);
                                    },
                                    'filter' => Html::activeDropDownList($searchModel,'status',DatabaseHelper::Status(),['class' => 'form-control','prompt' => '-------']),
                                ],
                                [
                                    'header' => 'Create Date',
                                    'value' => function($model){
                                        return Auction::$app->formatter->asDate($model->create_date);
                                    },
                                    'filter' => DatePicker::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'create_date',
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
                                    'statusColumn' => 'status',
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
    'deleteVerb'  => 'post',
    'updateVerb' => 'post',
    'viewUrl' => Url::to(['view']),
    'viewVerb' => 'post',
    'createVerb' => 'post',
    'modelTitle' => 'Auction Info',
    'template' => '{view}{delete}'
]); ?>






<?php /**
 *
 *'columns' => [
* ['class' => 'yii\grid\SerialColumn'],

*
* 'name',
* 'create_date:date',
* 'duration',

*
* [
* 'class' => 'auction\components\helpers\ActionColumn',
* 'statusColumn' => 'status'
 * ]
 * ],
 *
 *
 *
// * ?>
?>
 *
 *
 */
?>