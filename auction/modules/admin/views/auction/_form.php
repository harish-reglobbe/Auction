<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use auction\components\helpers\DatabaseHelper;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model auction\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php Pjax::begin(['id' => 'brand-form','enablePushState' => false, 'timeout' => false])?>

    <?php $form = ActiveForm::begin([
        'id' => 'create-brand',
        //'action' => Url::to(['brand/create']),
        'options' => [
            'data-pjax' => 1,
        ],
        'enableClientValidation' => false

    ]); ?>

    <?= Html::hiddenInput('id', $model->id);?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'disabled' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(DatabaseHelper::Status()) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end();?>

</div>
