<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use auction\models\Categories;
use auction\models\Brands;
use auction\models\Lots;
/* @var $this yii\web\View */
/* @var $model auction\models\Brands */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brands-active-form">

    <?php //Pjax::begin(['id' => 'brand-form','enablePushState' => false, 'timeout' => false])?>

    <?php $form = ActiveForm::begin([
        'id' => 'create-brand',
        //'action' => Url::to(['brand/create']),
        'options' => [
            'data-pjax' => 1,
        ],
        'enableClientValidation' => false

    ]); ?>

    <?= Html::hiddenInput('id', $model->id);?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'brand_id')->dropDownList(ArrayHelper::map(Brands::find()->asArray()->all(),'id' ,'name')) ?>

    <?= $form->field($model, 'cat_id')->dropDownList(ArrayHelper::map(Categories::find()->asArray()->all(),'id' ,'name')) ?>

    <?= $form->field($model, 'lot_id')->dropDownList(ArrayHelper::map(Lots::find()->asArray()->all(),'id' ,'name')) ?>

    <?= $form->field($model, 'condition')->textarea(['row' => 3]) ?>

    <?= $form->field($model, 'extra_cond')->textarea(['row' => 5]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php //Pjax::end();?>

</div>
