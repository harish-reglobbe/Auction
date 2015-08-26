<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use auction\components\helpers\DatabaseHelper;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model auction\models\Auctions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auctions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_date')->widget(DatePicker::className(),[
        'model' => $searchModel,
        'attribute' => 'created_at',
        'template' => '{addon}{input}',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'disableEntry'=>true,
        ],
        'options' => [
            'data-pjax' => false
        ]
    ]) ?>

    <?= $form->field($model, 'duration')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(DatabaseHelper::Status()) ?>

    <?= $form->field($model, 'priority')->textInput() ?>

    <?= $form->field($model, 'security')->textInput() ?>

    <?= $form->field($model, 'is_percent')->textInput() ?>

    <?= $form->field($model, 'max_bid')->textInput() ?>

    <?= $form->field($model, 'cooling_prd')->textInput() ?>

    <?= $form->field($model, 'last_min_extd')->textInput() ?>

    <?= $form->field($model, 'max_extd')->textInput() ?>

    <?= $form->field($model, 'category')->textInput() ?>

    <?= $form->field($model, 'brand')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Create' , ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
