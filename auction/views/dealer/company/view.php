<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 14/8/15
 * Time: 3:06 PM
 */

use yii\widgets\DetailView;
use auction\components\helpers\BootstrapHelper;
use auction\components\helpers\DatabaseHelper;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use auction\models\Auctions;
use yii\widgets\ListView;
use yii\helpers\Html;
use auction\components\Auction;

$this->title = 'Company :: Info';
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Company: <?= $model->name ?>
        <span>
            <img src="<?= Yii::$app->request->baseUrl.'/uploads/dealers/thumbs/Harish(3)1441456035.jpg'?>" style="float: right">
        </span>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-8">
        <div class="chat-panel panel panel-green">
            <div class="panel-heading">
                <i class="fa fa-comments fa-fw"></i>
                Latest Company Auctions
                <div class="btn-group pull-right">
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?= ListView::widget([
                    'dataProvider' => Auctions::latestCompanyAuction($model->id),
                    'summary' => false,
                    'emptyText' => '<address>No Auction Found for this Company</address>',
                    'itemView' => '_latest_auctions'
                ])?>
            </div>
            <div class="panel-footer" >
                <?= Html::button(($model->dealerCompanies) ? ($model->dealerCompanies[0]->status) ? 'Unsubscribe' : 'Subscribe' : 'Subscribe',[
                    'class' => ($model->dealerCompanies) ? ($model->dealerCompanies[0]->status) ? 'btn btn-danger' : 'btn btn-info' : 'btn btn-info'
                ]) ?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel .chat-panel -->
    </div>
    <!-- /.col-lg-8 -->
    <div class="col-lg-4">
        <div class="panel panel-green">
            <div class="panel-heading">
                Company Info
                <div class="btn-group pull-right">
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Company Details
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="list-group">
                            <?= DetailView::widget([
                                'model' => $model,
                                'template' => '<a href="#" class="list-group-item">{label}<span class="pull-right text-muted small"><em>{value}</em></span></a>',
                                'attributes' => [
                                    'name',
                                    'domain',
                                    'contact',
                                    [
                                        'label' => 'is_active',
                                        'value' => DatabaseHelper::GetStatus($model->is_active)
                                    ],
                                    'user.email',
                                ]
                            ]) ?>
                        </div>
                        <!-- /.list-group -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel Address-->
                <?= BootstrapHelper::PanelInfo('Company Address','<address>'. $model->address .'</address>',false,['class' => 'panel panel-info'])?>
                <!-- /.panel Description-->
                <?= BootstrapHelper::PanelInfo('Company Description','<address>'. $model->description .'</address>',false,['class' => 'panel panel-info'])?>
            </div>
            <!-- /.panel .chat-panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.row -->
<?php $companyModel= $model->dealerCompanies[0];if($companyModel): ?>
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

                            <?= Html::hiddenInput('dc_id' , $companyModel->id)?>

                            <?= Html::hiddenInput('id' , $model->id)?>

                            <?= Html::dropDownList('category','',Auction::dropDownList('auction\models\Categories','id','name'),[]) ?>

                            <?= Html::dropDownList('brand','',Auction::dropDownList('auction\models\Brands','id','name'),[]) ?>

                            <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="fa fa-plus"></i>
                        </button>
                    </span>
                        </div>

                        <?php if($companyModel->dealerCompanyPreferences) :?>
                            <?php foreach($companyModel->dealerCompanyPreferences as $param):?>
                                <div class="form-group input-group">

                                    <?= $form->field($param->category0 , 'name')->textInput(['class' => 'form-control' ,'disabled' => 'disabled'])?>

                                    <?= $form->field($param->brand0 , 'name')->textInput(['class' => 'form-control' ,'disabled' => 'disabled'])?>

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
<?php endif;?>
<!-- /.row -->

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


