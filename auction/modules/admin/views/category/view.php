<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use auction\components\helpers\DatabaseHelper;
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Category Info
            </div>
            <!-- .panel-heading -->
            <div class="panel-body">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Category Full Info</a>
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
                                            [
                                                'label' => 'Status',
                                                'value' => DatabaseHelper::GetStatus($model->is_active)
                                            ],
                                        ]
                                    ])?>
                                </div>
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        Category Description
                                    </div>
                                    <div class="panel-body">
                                        <address>
                                            <?= Html::encode($model->description) ?>
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