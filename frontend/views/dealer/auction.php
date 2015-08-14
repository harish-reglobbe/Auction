<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\forms\AuctionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dealer Auctions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auctions-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterSelector' => 'select[name="per-page"]',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'auction0.name',
            [
                'header' => 'Start Date',
                'value' => 'auction0.start_date',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'create_date',
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'format' => 'yyyy-dd-mm',
                    ],
                    'options' => [
                        'readonly' => true
                    ]
                ])
            ],
//          //  'duration',
            'amount',
            'status',
            'auction0.amount'
        ],
    ]); ?>

    <?php echo \frontend\widgets\PageSize::widget([
        'sizes' => [
            10 => 10,
            20 => 20
        ]
    ]); ?>

</div>
