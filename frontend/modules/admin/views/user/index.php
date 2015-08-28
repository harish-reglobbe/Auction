<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\components\DatabaseHelper;
use yii\widgets\Pjax;
use frontend\widgets\PageSize;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\forms\UserSearchForm */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Users', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['id' => 'pjaxwidget',]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'email:email',
            'mobile',
            [
                'value' => function($model){
                    return $model->is_active ==1 ? "Yes" : "No";
                },
                'filter' => Html::activeDropDownList($searchModel, 'user_role', \yii\helpers\ArrayHelper::map(\frontend\models\Role::find()->all(),'id','id'),['class'=>'form-control']),
                'header' => 'User Role'
            ],
            [
                'value' => function($model){
                    return $model->is_active ==1 ? "Yes" : "No";
                },
                'filter' => Html::activeDropDownList($searchModel, 'is_active', DatabaseHelper::$activeStatus,['class'=>'form-control']),
                'header' => 'Status'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view-model}{delete-model}',
                'buttons' => [
                    'view-model' => function($url,$model){
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>','#', [
                            'class' => 'activity-view-link',
                            'data-id' => $model->id,
                            'data-toggle' => 'modal',
                            'data-target' => '#activity-view-link',
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
    'header' => '<h4 class="modal-title">View User</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',

]);
Modal::end();

Modal::begin([
    'id' => 'activity-delete-link',
    'header' => '<h4 class="modal-title">Delete User</h4>',
    'footer' => Html::a('Ok','#',[
            'class' => 'btn btn-primary',
            'onClick' => 'alert($("#activity-delete-link").attr(data-id));'
        ]).'<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
    'options' => [
        'data-id' => ''
    ]

]);
echo 'Are you sure to delete this user';
Modal::end();

?>

<?php $this->registerJs(
    "
    $('.activity-view-link').on('click',function() {
        var id= $(this).attr('data-id');
        $.ajax({
            type: 'get',
            url: '". Url::to(['user/view'])."',
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
            url: '". Url::to(['user/update'])."',
            data: {id : id},
            success: function(html){
                $('#activity-update-link').find('.modal-body').html(html);
            }
        });
    });

     $('.activity-delete-link').on('click',function() {
        $('#activity-delete-link').attr('data-id',$(this).attr('data-id'));
    });

    "
); ?>

