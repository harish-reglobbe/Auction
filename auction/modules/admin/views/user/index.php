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
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(['id' => 'pjax-gridview','timeout' => false,'enablePushState' =>false]); ?>

    <?= GridView::widget([
        'id' => 'user-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterSelector' => 'select[name="SearchUser[pageSize]"]',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
                'class' => 'auction\components\helpers\ActionColumn',
                'template' => '{view}{delete}'
            ],
        ],
    ]); ?>

    <?php echo PageSize::widget([
        'model' => $searchModel,
        'attribute' => 'pageSize',
        'options' => [
            'data-pjax' => '0',
        ],
    ]); ?>
    <?php Pjax::end();?>

</div>

<?= ModelCrud::widget([
    'deleteUrl' => Url::to(['delete']),
    'updateUrl' => Url::to(['update']),
    'createUrl' => Url::to(['create']),
    'viewUrl' => Url::to(['view']),
    'deleteVerb'  => 'post',
    'viewVerb' => 'post',
    'template' => '{view}{delete}',
]); ?>


