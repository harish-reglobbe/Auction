<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Brands;
use frontend\models\Categories;

/* @var $this yii\web\View */
/* @var $model frontend\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>


<?php
$this->registerJs('
    $.pjax.defaults.timeout = 5000;
    $("#product-form-pjax").on("pjax:success", function(data, status, xhr, options) {
            if(options.responseText == "Success"){
                $.pjax.reload({container: "#pjax-gridview", timeout: 2000});
                $("#activity-modal").modal("hide");
            }
    });
    ');
?>


<div class="products-form">

    <?php Pjax::begin(['id' => 'product-form-pjax', 'enablePushState' => FALSE]) ?>

    <?php $form = ActiveForm::begin([
        'id' => 'crud-model-form',
        'action' => ['product/create'],
        'options' => [
            'data-pjax' => true,
            ]
        ]);
    ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'image') ?>

    <?= $form->field($model, 'brand')->dropDownList(ArrayHelper::map(Brands::find()->all(),'id','name')) ?>

    <?= $form->field($model, 'category')->dropDownList(ArrayHelper::map(Categories::find()->all(),'id','name'),['select' => ''])?>

    <?= $form->field($model, 'lot') ?>

    <?= $form->field($model, 'prize') ?>

    <?= $form->field($model, 'condition') ?>

    <?= $form->field($model, 'extra_condition') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end() ?>

</div>

