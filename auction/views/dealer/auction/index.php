<?php

use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\web\JsExpression;
use auction\components\Auction;
use auction\widgets\jui\AutoComplete;

$this->title = 'Auctions';
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= $this->title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>


<div class="row" style="margin: 20px 20px 20px 0px";>
    <div class="col-lg-4">
        <div class="input-group custom-search-form">
            <?= AutoComplete::widget([
                'id' => 'name_search',
                'url' => Auction::createUrl('dealer/company/list-companies'),
                'options' => [
                    'class' => 'form-control',
                    'data-id' => '',
                    'placeholder' => 'Search..'
                ]
            ]); ?>
            <span class="input-group-btn">
            <?= Html::submitButton('<i class="fa fa-search"></i>', [
                'id' => 'company-id',
                'class' => 'btn btn-primary',
                'onClick' => new JsExpression('
                var id = $("#name_search").attr("data-id");
                if(id == ""){
                    return false;
                }else{
                    window.location.href = "'. Auction::createUrl('dealer/auction/view') .'&id="+id;
                }
                ')
            ]) ?>
            </span>
        </div>
    </div>
</div>

<div class="row">
    <?php Pjax::begin(['id' => 'pjax-gridview', 'timeout' => false, 'enablePushState' => false]) ?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_info_panel',
        'emptyText' => '',
        'summary' => false
    ])
    ?>
    <?php Pjax::end() ?>
</div>


