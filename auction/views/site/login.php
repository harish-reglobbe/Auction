<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-6 "><!--Add col-md-offset-3 to make it in center-->
        <div class="login-panel panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Sign In</h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'fieldClass' => 'auction\widgets\ActiveField',
                    'successCssClass' => false,
                    'options'=> ['role' => 'form']]); ?>
                <fieldset>

                <?= $form->field($model, 'username')->textInput(['placeholder' => 'Email/Mobile Number']) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']) ?>


                    <div class="checkbox login-checks">
                        <label style="padding-left: 0px;">
                            <?= Html::activeCheckbox($model,'rememberMe')?>
                        </label>
                        <?= Html::a('Forgot Password?',['site/reset-password'],['class'=>'fg-psw'])?>
                    </div>

                    <?= Html::submitButton('Login',['class' => 'btn btn-lg btn-info btn-block'])?>

                </fieldset>
                <?php ActiveForm::end(); ?>
                <?= Html::a('<i class="fa fa-pinterest"></i>Register as Dealer',['dealer/registration'], ['class' => 'btn btn-block btn-social btn-pinterest']); ?>
                <?= Html::a('<i class="fa fa-bitbucket"></i>Register as Company',['company/registration'], ['class' => 'btn btn-block btn-social btn-dropbox']); ?>
            </div>
        </div>
    </div>
</div>