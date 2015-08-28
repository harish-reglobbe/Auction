<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model auction\models\MessageTemplate */

$this->title = 'Create Message Template';
$this->params['breadcrumbs'][] = ['label' => 'Message Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-template-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
