<?php
use auction\components\helpers\BootstrapHelper;
use auction\widgets\DetailView;

?>
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-green">
            <div class="panel-heading">
                Dealer Info
                <div class="btn-group pull-right">
                    <a href="">De-Activate</a>
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
                                'attributes' => [
                                    'user0.name',
                                    'contact',
                                    'user0.email',
                                ]
                            ]) ?>
                        </div>
                        <!-- /.list-group -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->

                <!-- /.Dealer Description Panel Start -->
                <?php BootstrapHelper::PanelInfo('Delaer Address', $model->address); ?>
                <!-- /.Dealer Description Panel End -->

                <!-- /.panel-body -->
            </div>
            <!-- /.panel .chat-panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
