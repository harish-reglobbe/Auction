<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model auction\models\Lots */

$this->title = 'Create Lots';
$this->params['breadcrumbs'][] = ['label' => 'Lots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lots-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
