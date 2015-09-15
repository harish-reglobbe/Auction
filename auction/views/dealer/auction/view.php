<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 14/8/15
 * Time: 3:06 PM
 */

use auction\widgets\DetailView;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Auction :: Info';
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Auction: <?= $model->name ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php Pjax::begin(['id' => 'toggle-status',  'enablePushState' => false , 'clientOptions' => ['async' => false]])?>
<div class="row">
    <div class="col-lg-8">
        <div class="chat-panel panel panel-green">
            <div class="panel-heading">
                <i class="fa fa-comments fa-fw"></i>
                Auctions Lots
                <div class="btn-group pull-right">
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body"><?php //dump($model)?>
                <?= ListView::widget([
                    'dataProvider' => $model->getLots($model->id),
                    'summary' => false,
                    'emptyText' => '<address>No Lots Found for this Auction</address>',
                    'itemView' => '_latest_lots'
                ])?>
            </div>
            <div class="panel-footer" >
                <?= Html::a('Apply This Auction',Url::to(['apply' ,'id' => $model->id]))?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel .chat-panel -->
    </div>
    <!-- /.col-lg-8 -->
    <div class="col-lg-4">
        <div class="panel panel-green">
            <div class="panel-heading">
                Auction Info
                <div class="btn-group pull-right">
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">Auction Details</div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="list-group">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'duration',
                                    'start_date:date',
                                    'amount',
                                    'end_date:date',
                                    'status'
                                ]
                            ]) ?>
                        </div>
                        <!-- /.list-group -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Company Details</div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="list-group">
                            <?= DetailView::widget([
                                'model' => $model->company0,
                                'attributes' => [
                                    'name',
                                    'domain',
                                    'address',
                                ]
                            ]) ?>
                        </div>
                        <!-- /.list-group -->
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
            <!-- /.panel .chat-panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.row -->