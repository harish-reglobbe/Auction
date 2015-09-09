<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model auction\models\Products */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'product_id',
            'name',
            'image',
            'brand_id',
            'cat_id',
            'lot_id',
            'prize',
            'condition',
            'create_date' => [
                'label' => 'Create Date',
                'value' => Yii::$app->formatter->asDate($model->create_date->sec)
            ]
        ],
    ]) ?>

</div>
