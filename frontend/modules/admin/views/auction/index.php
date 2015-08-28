<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\forms\AuctionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auctions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auctions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Auctions', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'create_date',
            'start_date',
            'duration',
            // 'amount',
            // 'company',
            // 'status',
            // 'priority',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
