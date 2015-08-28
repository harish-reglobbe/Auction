<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model auction\models\MessageTemplate */

$this->title = 'Update Message Template: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Message Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="message-template-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
