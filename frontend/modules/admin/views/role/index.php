<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use frontend\models\Role;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\forms\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Role', '#', [
            'class' => 'btn btn-success',
            'data-toggle' => 'modal',
            'data-target' => '#activity-create-link',
        ]) ?>
    </p>
    <?php Pjax::begin(['id' => 'pjaxwidget']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'value' => function($model){
                    return \frontend\components\Reglobe::$app->formatter->asDate($model->created_on);
                },
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_on',
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-dd-mm',
                        'disableEntry'=>true,
                    ],

                ])
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
    <?php Pjax::end();?>

</div>

<?php
//----------------------------------------------Modals Begin Update-View-Delete-Create-----------------------------------------

Modal::begin([
    'id' => 'activity-view-link',
    'header' => '<h4 class="modal-title">View Role</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]);
Modal::end();

Modal::begin([
    'id' => 'activity-update-link',
    'header' => '<h4 class="modal-title">Update Role</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]);
Modal::end();

Modal::begin([
    'id' => 'activity-delete-link',
    'header' => '<h4 class="modal-title">Delete Role</h4>',
    'footer' => Html::a('Ok','#',[
            'class' => 'btn btn-primary',
            'onClick' => 'alert($("#activity-delete-link").attr(data-id));'
        ]).'<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
    'options' => [
        'data-id' => ''
    ]

]);
echo 'Are you sure to delete this Item';
Modal::end();

Modal::begin([
    'id' => 'activity-create-link',
    'header' => '<h4 class="modal-title">Add Role</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]);

$newModel= new Role();
echo $this->renderAjax('_form',['model' => $newModel]);

Modal::end();

?>

<?php $this->registerJs(
    "
    $('.activity-view-link').on('click',function() {
        var id= $(this).attr('data-id');
        $.ajax({
            type: 'get',
            url: '". Url::to(['role/view'])."',
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
            url: '". Url::to(['role/update'])."',
            data: {id : id},
            success: function(html){
                $('#activity-update-link').find('.modal-body').html(html);
            }
        });
    });

    "
); ?>
