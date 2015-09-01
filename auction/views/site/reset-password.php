<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::$app->name. ':: Reset-Password';
?>
<div class="row">
    <div class="col-md-6 "><!--Add col-md-offset-3 to make it in center-->
        <div class="login-panel panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Reset Password</h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'fieldClass' => 'auction\widgets\ActiveField',
                    'successCssClass' => false,
                    'options'=> ['role' => 'form']]); ?>
                <fieldset>

                    <?= $form->field($model, 'username')->textInput() ?>

                    <?= Html::submitButton('Change Password',['class' => 'btn btn-lg btn-info btn-block'])?>

                </fieldset>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>