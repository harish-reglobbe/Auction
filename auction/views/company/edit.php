<?php


use yii\helpers\Html;
use auction\components\Auction;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
use auction\components\helpers\BootstrapHelper;

$this->title = Auction::$app->name.' :: Edit Company';

?>
<div class="row">
    <?php if(Auction::$app->session->hasFlash('success')):?>

        <?php Alert::begin([
            'options' => [
                'class' => 'alert-success',
            ],
        ]);

        echo 'Company Registration Success';

        Alert::end();?>

    <?php endif;?>
    <div class="col-md-6 "><!--Add col-md-offset-3 to make it in center-->
        <div class="login-panel panel panel-info" style="margin-top: 0px;">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Company</h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'successCssClass' => false,
                    'fieldClass' => 'auction\widgets\ActiveField',
                    'options'=> ['role' => 'form' ,'enctype' => 'multipart/form-data']]); ?>
                <fieldset>

                    <?= $form->field($model, 'name')->textInput() ?>

                    <?= $form->field($model, 'domain')->textInput() ?>

                    <?= $form->field($model, 'mobile')->textInput() ?>

                    <?= $form->field($model, 'contact')->textInput() ?>

                    <?= $form->field($model, 'profile_pic')->fileInput(['class' => false]) ?>

                    <?= $form->field($model, 'email')->textInput(['disabled' => true]) ?>

                    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

                    <?= Html::submitButton('Edit Company',['class' => 'btn btn-lg btn-info btn-block'])?>

                </fieldset>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
    <div class="col-md-4">
    <?= BootstrapHelper::PanelInfo('Company Image',Html::img(Auction::$app->request->baseUrl.'/uploads/company/thumbs/'.$model->profile_pic),false, ['class' => 'panel panel-success'])?>
    </div>
</div>