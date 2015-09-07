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
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use auction\models\Auctions;
use yii\widgets\ListView;
use yii\helpers\Html;

$this->title = 'Company :: Info';
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Company: <?= $model->name ?>
        <span><img src="<?= Yii::$app->request->baseUrl.'/uploads/dealers/thumbs/Harish(3)1441456035.jpg'?>" style="float: right"></span>
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
<?php if($model->dealerCompanies): ?>
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <button class="btn btn-info" type="button" id="create-modal">+ Add More Preferences</button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?= GridView::widget([
                    'dataProvider' => new ArrayDataProvider(['allModels' => $model->dealerCompanies[0]->dealerCompanyPreferences]),
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'category0.name',
                        'brand0.name',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update}',
                            'buttons' => [
                                'update' => function($model){
                                    return Html::button('Update',['class' => 'btn btn-success']);
                                }
                            ]
                        ]
                    ],
                ]); ?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<?php endif;?>
<!-- /.row -->


