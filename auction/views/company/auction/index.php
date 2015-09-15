<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel auction\models\forms\SearchAuction */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auctions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auctions-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Auctions', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'start_date:date',
            'duration',
            'amount',
            [
                'class' => 'auction\widgets\grid\StatusColumn',
                'statusColumn' => 'status'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
