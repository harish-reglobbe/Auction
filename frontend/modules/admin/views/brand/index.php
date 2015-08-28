<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use frontend\widgets\PageSize;
use dosamigos\datepicker\DatePicker;
use frontend\components\DatabaseHelper;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Brands';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Brand', '#', [
            'class' => 'btn btn-success',
            'data-toggle' => 'modal',
            'data-target' => '#activity-create-link',
        ]) ?>
    </p>

    <?php Pjax::begin(['id' => 'pjaxwidget',]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterSelector' => 'select[name="per-page"]',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'value' => 'description',
                'header' => 'Description'
            ],
            [
                'value' => function($model){
                    return \frontend\components\Reglobe::$app->formatter->asDate($model->create_date);
                },
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date',
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-dd-mm',
                        'disableEntry'=>true,
                    ],

                ])
            ],
            'image',
            [
                'value' => function($model){
                    return $model->is_active ==1 ? "Yes" : "No";
                },
                'filter' => Html::activeDropDownList($searchModel, 'status', DatabaseHelper::$activeStatus,['class'=>'form-control']),
                'header' => 'Status'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view-model}{update-model}{delete-model}',
                'buttons' => [
                    'view-model' => function($url,$model){
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>','#', [
                            'class' => 'activity-view-link',
                            'data-id' => $model->id,
                            'data-toggle' => 'modal',
                            'data-target' => '#activity-view-link',
                        ]);
                    },
                    'update-model' => function($url,$model){
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#', [
                            'class' => 'activity-update-link',
                            'data-id' => $model->id,
                            'data-toggle' => 'modal',
                            'data-target' => '#activity-update-link',
                        ]);
                    },
                    'delete-model' => function($url,$model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>','#', [
                            'class' => 'activity-delete-link',
                            'data-id' => $model->id,
                            'data-toggle' => 'modal',
                            'data-target' => '#activity-delete-link',
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>
    <?php echo PageSize::widget([]); ?>
    <?php Pjax::end();?>

</div>

<?php
//----------------------------------------------Modals Begin Update-View-Delete-Create-----------------------------------------

Modal::begin([
    'id' => 'activity-view-link',
    'header' => '<h4 class="modal-title">View Category</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]);
Modal::end();

Modal::begin([
    'id' => 'activity-update-link',
    'header' => '<h4 class="modal-title">Update Category</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]);
Modal::end();

Modal::begin([
    'id' => 'activity-delete-link',
    'header' => '<h4 class="modal-title">Delete Category</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]);
echo 'Are you Sure To Delete This Item';
Modal::end();

Modal::begin([
    'id' => 'activity-create-link',
    'header' => '<h4 class="modal-title">Add Category</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]);

$newModel= new \frontend\models\Brands();
echo $this->renderAjax('_form',['model' => $newModel]);

Modal::end();

?>

<?php $this->registerJs(
    "
    $('.activity-view-link').on('click',function() {
        var id= $(this).attr('data-id');
        $.ajax({
            type: 'get',
            url: '". Url::to(['category/view'])."',
            data: {id : id},
            success: function(html){
                $('#activity-view-link').find('.modal-body').html(html);
            }
        });
    });

    $('.activity-update-link').on('click',function() {
        var id= $(this).attr('data-id');
        $.ajax({
            type: 'post',
            url: '". Url::to(['category/update'])."',
            data: {id : id},
            success: function(html){
                $('#activity-update-link').find('.modal-body').html(html);
            }
        });
    });

    "
); ?>
