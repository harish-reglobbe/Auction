<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use auction\models\Categories;

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
            'enctype' => 'multipart/form-data'
        ],
        'enableClientValidation' => false

    ]); ?>


    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'typeName')->textInput() ?>

    <?= $form->field($model, 'cat_id')->dropDownList(ArrayHelper::map(Categories::find()->asArray()->all() , 'id', 'name')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->name == '' ? 'Create' : 'Update', ['class' => $model->name == '' ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end();?>

</div>

