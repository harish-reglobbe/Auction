<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-form">

    <?php $form = ActiveForm::begin([
        'action' => ['category/create'],
        'id' => 'create-category'
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model,'id')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'is_active')->dropDownList(\frontend\components\DatabaseHelper::$activeStatus); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id' => 'save-category']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$this->registerJs('
    $("#save-category").click(function(){
    alert("hi");
    var formData=$("#create-category").serialize();
    $.ajax({
    type: "post",
    url: "'. Yii::$app->urlManager->createAbsoluteUrl('/admin/category/save')  .'",
    data: {formData:formData},
    success: function($data){

    }
    });
    return false;
    });
');

?>
