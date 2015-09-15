<?php

use auction\widgets\DetailView;
use auction\widgets\grid\GridView;
use yii\helpers\Url;

$this->title = "Auction::Info";
?>
<div class="row">
    <div class="col-lg-12">
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="chat-panel panel panel-green">
            <div class="panel-heading">
                <i class="fa fa-comments fa-fw"></i>
                Lots
                <div class="btn-group pull-right">
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="panel-heading">
                    <button class="btn btn-green" type="button" id="create-modal">+ Add More Lots</button>
                </div>
                <?= GridView::widget([
                    'dataProvider' => $model->getLots($model->id),
                    'modalSize' => \yii\bootstrap\Modal::SIZE_SMALL,
                    'createUrl' => Url::to(['company/lots/create' ,'auction' => $model->id]),
                    'updateUrl' => Url::to(['company/lots/update']),
                    'isShowForm' => false,
                    'columns' => [
                        'name',
                        'condition',
                        'lot_size',
                        'lotPreferences.category0.name',
                        'lotPreferences.brand0.name',
                        [
                            'class' => 'auction\widgets\grid\ActionColumn',
                            'template' => '{delete}{update}'
                        ]
                    ]
                ])?>
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
                    <div class="panel-heading">
                        Auction Details
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="list-group">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'name',
                                    'start_date:date',
                                    'duration',
                                    'amount',
                                    'company',
                                    'status',
                                    'priority',
                                ],
                            ])?>
                        </div>
                        <!-- /.list-group -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Bid Info
                    </div>
                    <div class="panel-body">
                        <div class="list-group">
                            <?= DetailView::widget([
                                'model' => $model->bidsTerms,
                                'attributes' => [
                                    'max_bid',
                                    'cooling_prd',
                                    'last_min_extd',
                                    'max_extd',
                                ],
                            ])?>
                        </div>
                    </div>
                    <!-- /.col-lg-4 -->
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Auction Criteria
                    </div>
                    <div class="panel-body">
                        <div class="list-group">
                            <?= DetailView::widget([
                                'model' => $model->auctionsCriterias,
                                'attributes' => [
                                    'security'
                                ],
                            ])?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Auction Preferences
                    </div>
                    <div class="panel-body">
                        <div class="list-group">
                            <?= DetailView::widget([
                                'model' => $model->auctionPreferences,
                                'attributes' => [
                                    [                      // the owner name of the model
                                        'label' => 'Category',
                                        'value' => $model->auctionPreferences->category0->name,
                                    ],
                                    [                      // the owner name of the model
                                        'label' => 'Brand',
                                        'value' => $model->auctionPreferences->brand0->name,
                                    ],
                                ],
                            ])?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Company Info
                    </div>
                    <div class="panel-body">
                        <div class="list-group">
                            <?= DetailView::widget([
                                'model' => $model->company0,
                                'attributes' => [
                                    'name',
                                    'contact'
                                ],
                            ])?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs('
jQuery(document).on("pjax:success", "#brand-form",  function(event){
    $.pjax.reload({
    container:"#pjax-gridview",timeout:2e3
    }),$("#activity-modal").modal("hide")
    });
jQuery(document).pjax("#brand-form a", "#brand-form", {
    "push":false,
    "replace":false,
    "timeout":false,
    "scrollTo":false
    });
jQuery(document).on("submit", "#brand-form form[data-pjax]", function (event) {
    jQuery.pjax.submit(event, "#brand-form", {
        "push":false,
        "replace":false,
        "timeout":false,
        "scrollTo":false
        });
    });
');
?>