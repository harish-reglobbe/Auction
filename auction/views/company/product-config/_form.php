<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use auction\components\Auction;

/* @var $this yii\web\View */
/* @var $model auction\models\Brands */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brands-active-form">

    <?php Pjax::begin(['id' => 'brand-form','enablePushState' => false, 'timeout' => false])?>

    <?php $form = ActiveForm::begin([
        'id' => 'create-brand',
        //'action' => Url::to(['brand/create']),
        'options' => [
            'data-pjax' => 1,
        ],
        'enableClientValidation' => false

    ]); ?>


    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'cat_id')->dropDownList(Auction::dropDownList('auction\models\Categories', 'id', 'name')) ?>

    <?= $form->field($model, 'brand_id')->dropDownList(Auction::dropDownList('auction\models\Brands', 'id', 'name')) ?>

    <?= $form->field($model, 'company')->hiddenInput(['value' => Auction::company()])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => ($model->isNewRecord) ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end();?>

</div>

