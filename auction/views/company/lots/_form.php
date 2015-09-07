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
    'action' => Auction::createUrl('company/lots/create'),
    'fieldClass' => 'auction\widgets\ActiveField',
    'options' => [
        'data-pjax' => 1,
    ],
]); ?>

<fieldset>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'auction')->dropDownList(ArrayHelper::map(Auctions::find()->all(),'id','name'),['class' => 'form-control']) ?>

    <?= $form->field($model, 'condition')->textInput() ?>

    <?= $form->field($model, 'is_quantity')->textInput() ?>

    <?= Html::submitButton('Create a new lot',['class' => 'btn btn-lg btn-info btn-block'])?>

</fieldset>
<?php ActiveForm::end(); ?>

<?php Pjax::end();?>
