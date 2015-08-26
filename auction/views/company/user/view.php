<?php

use yii\widgets\DetailView;
use auction\components\helpers\DatabaseHelper;
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                User Profile
            </div>
            <!-- .panel-heading -->
            <div class="panel-body">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">User Info</a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="list-group">
                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'template' => '<a href="#" class="list-group-item">{label}<span class="pull-right text-muted small"><em>{value}</em></span></a>',
                                        'attributes' => [
                                            'name',
                                            'email',
                                            'mobile',
                                            [
                                                'label' => 'Status',
                                                'value' => DatabaseHelper::GetStatus($model->is_active)
                                            ],
                                        ]
                                    ])?>
                                </div>
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        Address
                                    </div>
                                    <div class="panel-body">
                                        <address>
                                            N/A
                                        </address>
                                    </div>
                                    <!-- /.col-lg-4 -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- .panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->