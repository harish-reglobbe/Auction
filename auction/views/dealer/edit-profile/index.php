<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use auction\components\Auction;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

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
                    <?= $form->field($model, 'city')->textInput() ?>
                    <?= $form->field($model, 'address')->textarea() ?>

                    <?= $form->field($model->user0, 'email')?>
                    <?= $form->field($model->user0, 'mobile')?>
                    <?= $form->field($model->user0, 'profile_pic')->fileInput(['class' => false])?>

                    <?= Html::submitButton('Update Profile',['class' => 'btn btn-lg btn-info btn-block'])?>

                </fieldset>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
<!--    Col -md -6-->
    <div class="col-md-6">
        <img src="<?= Auction::$app->request->baseUrl.'/uploads/dealers/'.$model->user0->profile_pic?>" style="width: 400px;">
    </div>
</div>


<div class="row">
    <div class="col-md-6 "><!--Add col-md-offset-3 to make it in center-->
        <div class="login-panel panel panel-info" style="margin-top: 20px">
            <div class="panel-heading">
                <h3 class="panel-title">Add Preferences</h3>
            </div>
            <div class="panel-body">
                <?php Pjax::begin(['id' => 'create-preferences',  'enablePushState' => false]) ?>
                <?php $form = ActiveForm::begin([
                    'id' => 'update-preferences',
                    'action' => \yii\helpers\Url::to(['add-preference']),
                    'fieldClass' => 'auction\widgets\ActiveField',
                    'successCssClass' => false,
                    'options'=> ['role' => 'form' , 'data-pjax' => true]]); ?>
                <fieldset>
                    <div class="form-group input-group">
                        <?= Html::dropDownList('category','',Auction::dropDownList('auction\models\Categories','id','name'),[]) ?>
                        <?= Html::dropDownList('brand','',Auction::dropDownList('auction\models\Brands','id','name'),[]) ?>
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="fa fa-plus"></i>
                        </button>
                    </span>
                    </div>

                    <?php if($model->dealerPreferences) :?>
                    <?php foreach($model->dealerPreferences as $param):?>

                        <div class="form-group input-group">
                            <?= Html::activeTextInput($param->category0, 'name',['class' => 'form-control' ,'disabled' => 'disabled']) ?>
                            <?= Html::activeTextInput($param->brand0, 'name',['class' => 'form-control' ,'disabled' => 'disabled']) ?>
                            <span class="input-group-btn">
                        <?= Html::button('<i class="fa fa-minus"></i>',['class' => 'btn btn-default delete-button' ,'id' => $param->primaryKey])?>
                    </span>
                        </div>

                    <?php endforeach; ?>
                    <?php endif ?>

                </fieldset>
                <?php ActiveForm::end(); ?>
                <?php Pjax::end() ?>
            </div>
        </div>
    </div>
    <!--    Col -md -6-->
</div>

<?php
$this->registerJs('
jQuery(document).on("click" , ".delete-button" ,function(){
    var id = $(this).attr("id");
    $.ajax({
    type: "post",
    url : "'. \yii\helpers\Url::to(['delete-preference']) .'",
    data: {id : id},
    success : function(t){
        $.pjax.reload({container:"#create-preferences",timeout:2e3});
    }
    });
});
jQuery(document).on("pjax:error", "#create-preferences",  function(event){alert ("Already Added");});
');

?>