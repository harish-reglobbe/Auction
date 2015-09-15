<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use auction\models\Auctions;
use yii\widgets\Pjax;
use auction\components\Auction;

/* @var $this yii\web\View */
/* @var $model auction\models\Lots */
/* @var $form yii\widgets\ActiveForm */
?>
<?php Pjax::begin(['id' => 'brand-form','enablePushState' => false, 'timeout' => false])?>

<?php $form = ActiveForm::begin([
    'id' => 'create-brand',
    'fieldClass' => 'auction\widgets\ActiveField',
    'options' => [
        'data-pjax' => 1,
    ],
]); ?>

<fieldset>

    <?= Html::hiddenInput('id', $model->id);?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?php if($model->auction === null): ?>
        <?= $form->field($model, 'auction')->dropDownList(ArrayHelper::map(Auctions::find()->all(),'id','name'),['class' => 'form-control']) ?>
        <?php else:?>
        <?= $form->field($model , 'auction')->hiddenInput() ?>
    <?php endif;?>

    <?= $form->field($model, 'condition')->textInput() ?>

    <?= $form->field($model, 'lot_size')->textInput() ?>

    <?= $form->field($model, 'is_quantity')->textInput() ?>

    <?= $form->field($model->lotPreferences, 'brand')->dropDownList(Auction::dropDownList('auction\models\Brands' , 'id', 'name')) ?>

    <?= $form->field($model->lotPreferences, 'category')->dropDownList(Auction::dropDownList('auction\models\Categories' , 'id', 'name')) ?>

    <?= Html::submitButton(($model->isNewRecord) ? 'Create a new lot' : 'Update Lot',['class' => 'btn btn-lg btn-info btn-block'])?>

</fieldset>
<?php ActiveForm::end(); ?>

<?php Pjax::end();?>
