<?php

use auction\widgets\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel auction\models\forms\SearchLot */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="lots-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'isShowForm' => false,
        'pjaxOptions'=> ['id' => 'lots-pjax-gridview','timeout' => false, 'enablePushState' => false,'options' => ['class' => 'dataTable_wrapper']],
        'columns' => [
            ['class' => 'auction\widgets\grid\RadiobuttonColumn'],
            'name',
            'auction0.name',
            'lot_size',
        ],
        'options' => [
            'id' => 'lot-table-grid'
        ]
    ]); ?>

    <?= Html::button('Submit',['id' => 'save-lot-id', 'class' => 'btn btn-primary'])?>

    <?= Html::a('<i class="fa fa-github"></i>Create a New Lot','#',[
        'id' => 'create-lot-modal',
        'class' => 'btn btn-block btn-social btn-github' ,
        ])?>

</div>
