<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use auction\components\Auction;
use auction\components\helpers\DatabaseHelper;
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Auction Info
            </div>
            <!-- .panel-heading -->
            <div class="panel-body">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Auction Full Info</a>
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
                                            'amount',
                                            'duration',
                                            'priority',
                                            'create_date:date',
                                            [
                                                'label' => 'Status',
                                                'value' => DatabaseHelper::GetStatus($model->status)
                                            ],
                                        ]
                                    ])?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Company Info</a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="list-group">
                                    <?= DetailView::widget([
                                        'model' => $model->company0,
                                        'template' => '<a href="#" class="list-group-item">{label}<span class="pull-right text-muted small"><em>{value}</em></span></a>',
                                        'attributes' => [
                                            'name',
                                            'contact',
                                            [
                                                'label' => 'Status',
                                                'value' => DatabaseHelper::GetStatus($model->company0->is_active)
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
                                            <strong>Twitter, Inc.</strong>
                                            <br>795 Folsom Ave, Suite 600
                                            <br>San Francisco, CA 94107
                                            <br>
                                            <abbr title="Phone">P:</abbr>(123) 456-7890
                                        </address>
                                    </div>
                                    <!-- /.col-lg-4 -->
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Auction Criteria</a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="list-group">
                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'template' => '<a href="#" class="list-group-item">{label}<span class="pull-right text-muted small"><em>{value}</em></span></a>',
                                        'attributes' => [
                                            'auctionsCriterias.security',
                                            'auctionsCriterias.is_percent',
                                            'bidsTerms.max_bid',
                                            'bidsTerms.cooling_prd',
                                            'bidsTerms.last_min_extd',
                                            'bidsTerms.max_extd'
                                        ]
                                    ])?>
                                </div>
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