<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\forms\AuctionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auctions';
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

//            'name',
//            [
//                'header' => 'Start Date',
//                'value' => function($model){
//                    return date("d M Y",  strtotime($model->start_date));
//                },
//                'filter' => DatePicker::widget([
//                    'model' => $searchModel,
//                    'attribute' => 'start_date',
//                    'template' => '{addon}{input}',
//                    'clientOptions' => [
//                        'autoclose' => true,
//                        'format' => 'yyyy-dd-mm',
//                        'disableEntry'=>true,
//                    ],
//                    'options' => [
//                        'readonly' => true
//                    ]
//                ])
//            ],
//          //  'duration',
//            'amount',
//            [
//                'header' => 'Company Name',
//                'value' => 'companies.name',
//                'filter' => Html::activeTextInput($searchModel, 'company',['class'=>'form-control'])
//            ],
//            'status',
//            'priority',
        ],
    ]); ?>

    <?php echo \frontend\widgets\PageSize::widget([
        'sizes' => [
            10 => 10,
            20 => 20
        ]
    ]); ?>

</div>
