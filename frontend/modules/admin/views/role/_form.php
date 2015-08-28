<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-form">

    <?php $form = ActiveForm::begin([
        'id' => 'role-update-form',
        'enableClientValidation'=>false
    ]); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true])->label('Role Name') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id' => 'submit-role']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->registerJs("

    $('#submit-role').on('click',function(){
    var url='". Yii::$app->urlManager->createAbsoluteUrl('admin/role/create') ."';
    var formData=$('#role-update-form').serialize();
    $.ajax({
    type: 'post',
    url: url,
    data: formData,
    success: function(data){
        $.pjax.reload({container:'#pjaxwidget'});
    }
    });
    return false;
    });

");
?>
