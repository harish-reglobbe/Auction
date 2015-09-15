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
        'template' => '{addon}{input}',
        'value' => 'x',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'disableEntry'=>true,
        ],
        'options' => [
            'value' => Yii::$app->formatter->asDate($model->start_date ,'php: Y-m-d'),
            'data-pjax' => false
        ]
    ]) ?>

    <?= $form->field($model, 'duration')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(DatabaseHelper::Status()) ?>

    <?= $form->field($model, 'priority')->textInput() ?>

    <?= $form->field($model->auctionsCriterias, 'security')->textInput() ?>

    <?= $form->field($model->auctionsCriterias, 'is_percent')->textInput() ?>

    <?= $form->field($model->bidsTerms, 'max_bid')->textInput() ?>

    <?= $form->field($model->bidsTerms, 'cooling_prd')->textInput() ?>

    <?= $form->field($model->bidsTerms, 'last_min_extd')->textInput() ?>

    <?= $form->field($model->bidsTerms, 'max_extd')->textInput() ?>

    <?= $form->field($model->auctionPreferences, 'category')->dropDownList(\auction\components\Auction::dropDownList('auction\models\Categories' , 'id' ,'name')) ?>

    <?= $form->field($model->auctionPreferences, 'brand')->dropDownList(\auction\components\Auction::dropDownList('auction\models\Brands' ,'id' , 'name')) ?>

    <div class="form-group">
        <?= Html::submitButton('Update' , ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
