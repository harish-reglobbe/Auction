<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model auction\models\ProductConfig */

$this->title = 'Create Product Config';
$this->params['breadcrumbs'][] = ['label' => 'Product Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
