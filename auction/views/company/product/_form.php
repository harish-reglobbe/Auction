<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use auction\models\Categories;
use auction\models\Brands;

/* @var $this yii\web\View */
/* @var $model auction\models\Brands */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brands-active-form">


    <?php $form = ActiveForm::begin([
        'id' => 'create-brand',
        //'action' => Url::to(['brand/create']),
        'options' => [
            'enctype' => 'multipart/form-data'
        ],
        'enableClientValidation' => false

    ]); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'brand_id')->dropDownList(ArrayHelper::map(Brands::find()->asArray()->all(),'id' ,'name')) ?>

    <?= $form->field($model, 'brand')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'cat_id')->dropDownList(ArrayHelper::map(Categories::find()->asArray()->all(),'id' ,'name')) ?>

    <?= $form->field($model, 'category')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'prize')->textInput() ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <?= $form->field($model, 'condition')->textarea(['row' => 2]) ?>

    <?= $form->field($model, 'extra_cond')->textarea(['row' => 2, 'value' => ($model->isNewRecord) ? '' : implode('||',$model->extra_cond)]) ?>

    <?= $form->field($model, 'summary')->textarea(['row' => 2]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
//Active Form Before Save Event
$js= 'jQuery(document).on("beforeSubmit","#create-brand", function(e) {
        var category = $("#products-cat_id option:selected").text();
        var brand = $("#products-brand_id option:selected").text();
        $("#products-category").val(category);
        $("#products-brand").val(brand);
});';

$this->registerJs($js);

?>
