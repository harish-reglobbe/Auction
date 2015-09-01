<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 14/8/15
 * Time: 3:06 PM
 */

use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\data\ArrayDataProvider;
use auction\components\helpers\BootstrapHelper;

$this->title='Dealer Profile';
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dealer Name: <?= $model->user0->name?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php

echo ListView::widget([
    'dataProvider' => new ArrayDataProvider(['allModels' => $model->dealerDetails,'pagination' => false]),
    'itemView' => '_row1',
    'summary' => false,
    'itemOptions' => [
        'class' => 'col-lg-3 col-md-6'
    ],
    'options' => [
        'class' => 'row',
        'id' => false
    ]
])?>
<!-- /.row -->
<div class="row">
    <div class="col-lg-8">
        <div class="chat-panel panel panel-green">
            <div class="panel-heading">
                <i class="fa fa-comments fa-fw"></i>
                Latest Auctions
                <div class="btn-group pull-right">
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <ul class="chat">

                    <li class="right clearfix">
                                <span class="chat-img pull-right">
                                    <img src="http://placehold.it/50/FA6F57/fff" alt="User Avatar" class="img-circle" />
                                </span>
                        <div class="chat-body clearfix">
                            <div class="header">
                                <small class=" text-muted">
                                    <i class="fa fa-clock-o fa-fw"></i> 15 mins ago</small>
                                <strong class="pull-right primary-font">Bhaumik Patel</strong>
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel .chat-panel -->
    </div>
    <!-- /.col-lg-8 -->
    <div class="col-lg-4">
        <div class="panel panel-green">
            <div class="panel-heading">
                Dealer Info
                <div class="btn-group pull-right">
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Dealer Details
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="list-group">
                            <?= DetailView::widget([
                                'model' => $model,
                                'template' => '<a href="#" class="list-group-item">{label}<span class="pull-right text-muted small"><em>{value}</em></span></a>',
                                'attributes' => [
                                    'user0.name',
                                    'contact',
                                    'user0.email',
                                ]
                            ])?>
                        </div>
                        <!-- /.list-group -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->

                <!-- /.Dealer Description Panel Start -->
                <?php BootstrapHelper::PanelInfo('Delaer Address',$model->address); ?>
                <!-- /.Dealer Description Panel End -->

                <!-- /.panel-body -->
            </div>
            <!-- /.panel .chat-panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
