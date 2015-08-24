<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\widgets\ModelCrud;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\forms\ProductSearchForm */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', '#', ['class' => 'btn btn-success', 'id' => 'create-modal',]) ?>
    </p>

    <?php Pjax::begin(['id' => 'pjax-gridview', 'enablePushState' => false])?>

    <?= GridView::widget([
        'id' => 'products-grid',
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
          //  'extra_cond',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function($url,$model){
                        return  Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '#', [
                            'class' => 'view-modal',
                            'data-id' => $model->product_id,
                        ]);
                    },
                    'update' => function($url,$model){
                        return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
                            'class' => 'update-modal',
                            'data-id' => $model->product_id,
                        ]);
                    },
                    'delete' => function($url,$model){
                        return  Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', [
                            'class' => 'delete-modal',
                            'data-id' => $model->product_id,
                        ]);
                    }
                ]
            ]
        ],
    ]); ?>

    <p>
        <?= Html::a('Delete Selected', '#', ['class' => 'btn btn-success', 'id' => 'delete-selected-products',]) ?>
    </p>

    <?php Pjax::end()?>

</div>

<?= ModelCrud::widget([
    'deleteUrl' => Url::to(['delete']),
    'updateUrl' => Url::to(['update']),
    'createUrl' => Url::to(['create']),
    'viewUrl' => Url::to(['view']),
    'pjaxContainerId' => 'pjax-gridview',
    'deleteVerb' => 'post'
]);?>
<?php $this->registerJs('jQuery(document).on("click","#delete-selected-products",function(){var e=$("#products-grid").yiiGridView("getSelectedRows");return $.ajax({type:"post",url:"'.Url::to(['delete']).'",data:{id:e},success:function(){$.pjax.reload({container:"#pjax-gridview",timeout:2e3})}}),!1});');?>