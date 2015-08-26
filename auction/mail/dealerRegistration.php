<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Dealers */
/* @var $form ActiveForm */
?>
<div class="dealer-registration">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'city') ?>
    <?= $form->field($model, 'contact') ?>
    <?= $form->field($model, 'login_name') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'password') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- dealer-registration -->
