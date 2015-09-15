<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model auction\models\Brands */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-6 "><!--Add col-md-offset-3 to make it in center-->
        <div class="login-panel panel panel-info" style="margin-top: 20px;">
            <div class="panel-heading">
                <h3 class="panel-title">Update Config Setting</h3>
            </div>
            <div class="panel-body">
                <?php Pjax::begin(['id' => 'brand-form','enablePushState' => false, 'timeout' => 10000])?>

                <?php $form = ActiveForm::begin([
                    'id' => 'create-brand',
                    'action' => ['param-add'],
                    'fieldClass' => 'auction\widgets\ActiveField',
                    'options' => [
                        'data-pjax' => 1,
                        'enctype' => 'multipart/form-data'
                    ],
                    'enableClientValidation' => false

                ]); ?>

                <?= Html::activeHiddenInput($model,'id')?>

                <?= $form->field($model , 'name')->textInput(['readonly' => 'readonly'])?>

                <div class="form-group input-group">
                    <?= Html::textInput('param-name','',['class' => 'form-control']) ?>
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="fa fa-plus"></i>
                        </button>
                </span>
                </div>

                <?php foreach($model->prodConfParams as $param):?>

                    <div class="form-group input-group">
                        <?= Html::activeTextInput($param, 'name',['class' => 'form-control' ,'disabled' => 'disabled']) ?>
                        <span class="input-group-btn">
                        <?= Html::button('<i class="fa fa-minus"></i>',['class' => 'btn btn-default delete-button' ,'id' => $param->primaryKey])?>
                </span>
                    </div>

                <?php endforeach; ?>


                <?php ActiveForm::end(); ?>
                <?php Pjax::end();?>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs('
jQuery(document).on("click" , ".delete-button" ,function(){
    var id = $(this).attr("id");
    $.ajax({
    type: "post",
    url : "'. \yii\helpers\Url::to(['delete-param']) .'",
    data: {id : id},
    success : function(t){
        $.pjax.reload({container:"#brand-form",timeout:2e3});
    }
    });
});
');

?>
