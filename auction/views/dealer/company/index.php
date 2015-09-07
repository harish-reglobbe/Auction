<?php

use yii\bootstrap\Modal;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;
use auction\components\Auction;
use auction\widgets\jui\AutoComplete;

$this->title = 'Dealer :: Company';
?>

<?php $this->registerJs('
jQuery(document).on("click",".deactivate-company",function(){var t=$(this).attr("data-id");$("#delete-role-model").attr("data-id",t),$("#activity-delete-modal").modal("show")})
jQuery(document).on("click",".edit-preferences",function(){var t=$(this).attr("data-id");
    $.ajax({
        type: "post",
        url : "' . Url::to(['edit-preferences']) . '",
        data : {id: t},
        success : function(data){
                $("#activity-delete-modal").find(".modal-body").html(data),$("#activity-delete-modal").modal("show")
        }
    });
});
'); ?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dealer Companies</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
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
                    window.location.href = "/Auction/auction/web/index.php?r=dealer/company/view&id="+id;
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
</div>
<?php Pjax::end() ?>

<?php
Modal::begin([
    'id' => 'activity-delete-modal',
    'header' => '<h2>Dealer Company</h2>',
    'footer' => Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal'])
        . PHP_EOL . Html::button('Delete', [
            'class' => 'btn btn-primary btn-modal-save',
            'id' => 'delete-role-model',
            'data-id' => '',
            'onClick' => new JsExpression('var id=$("#delete-role-model").attr("data-id");$.ajax({type:"post",url:"' . Url::to(['delete']) . '",data:{id:id},success:function(){$.pjax.reload({container:"#pjax-gridview",timeout:2e3}),$("#activity-delete-modal").modal("hide")}});')
        ]),
]);

echo 'Are You Sure To Unsubscibe from this Company';
Modal::end();
?>


