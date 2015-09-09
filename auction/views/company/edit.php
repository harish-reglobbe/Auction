<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use auction\components\Auction;

$this->title = 'Edit::Profile';
?>
<div class="row">
    <div class="col-md-6 "><!--Add col-md-offset-3 to make it in center-->
        <div class="login-panel panel panel-info" style="margin-top: 20px">
            <div class="panel-heading">
                <h3 class="panel-title">Update Profile</h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'fieldClass' => 'auction\widgets\ActiveField',
                    'successCssClass' => false,
                    'options'=> ['role' => 'form' , 'enctype' => 'multipart/form-data']]); ?>
                <fieldset>

                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'address')->textarea() ?>

                    <?= $form->field($model->user, 'email')?>
                    <?= $form->field($model->user, 'mobile')?>
                    <?= $form->field($model->user, 'profile_pic')->fileInput(['class' => false])?>

                    <?= Html::submitButton('Update Profile',['class' => 'btn btn-lg btn-info btn-block'])?>

                </fieldset>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <!--    Col -md -6-->
    <div class="col-md-6">
        <img src="<?= Auction::$app->request->baseUrl.'/uploads/company/'.$model->user->profile_pic?>" style="width: 400px;">
    </div>
</div>