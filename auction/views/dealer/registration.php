<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use auction\components\Auction;

/* @var $this yii\web\View */
/* @var $model frontend\models\Dealers */
/* @var $form ActiveForm */
?>
<div class="dealer-registration">

    <?php if(Auction::$app->session->hasFlash('success')):?>
        Your Account is Successfully Created.Check Your Email Address to complete your Account Activation

    <?php else:?>

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

    <?php endif;?>

</div><!-- dealer-registration -->
