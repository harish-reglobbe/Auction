<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use auction\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

$this->title = Yii::$app->name. ':: Reset-Password';
?>
<div class="row">
    <div class="col-md-6 "><!--Add col-md-offset-3 to make it in center-->
        <div class="login-panel panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Reset Password</h3>
            </div>
            <div class="panel-body">
                <?php Pjax::begin(['id' => 'pjax-reset-form' , 'enablePushState' => false , 'timeout' => 10000])?>
                <?php $form = ActiveForm::begin([
                    'id' => 'reset-form',
                    'options'=> ['role' => 'form' , 'data-pjax' => '1']]); ?>
                <fieldset>

                    <?= $form->field($model, 'username')->textInput() ?>

                    <?= $form->field($model, 'via')->radioList(['email' => 'Email' , 'sms' => 'SMS']) ?>

                    <?= Html::submitButton('Change Password',['class' => 'btn btn-lg btn-info btn-block'])?>

                </fieldset>
                <?php ActiveForm::end(); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
Modal::begin([
    'id' => 'otp-modal',
    'header' => '<h2>Enter Your Otp</h2>',
    'size' => Modal::SIZE_SMALL,
    'footer' => Html::button('Close', ['class' => 'btn btn-info', 'data-dismiss' => 'modal']),
]);
Pjax::begin(['id' => 'pjax-otp-submit' , 'enablePushState' => false , 'timeout' =>false]);

$form = ActiveForm::begin([
    'id' => 'otp-form',
    'options'=> ['role' => 'form' , 'data-pjax' => '1']]);
?>
<fieldset>

    <?= Html::textInput('otp','',['class' => 'form-control']); ?>
    <br>
    <?= Html::submitButton('Enter Otp',['class' => 'btn btn-primary'])?>

</fieldset>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
<?php Modal::end(); ?>

<?php
$this->registerJs('
jQuery(document).on("pjax:success" ,"#pjax-reset-form" , function(event){
    $("#reset-form").yiiActiveForm("validate");
    var len = $("#reset-form").find(".has-error").length;
    if(len === 0){
        $("#otp-modal").modal("show");
    }
});
');
?>


