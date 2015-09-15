<?php

use yii\bootstrap\Modal;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;

$this->title= 'Company :: Dealers';
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">My Dealers</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<?php Pjax::begin(['id' => 'pjax-gridview','timeout' => false, 'enablePushState' => false])?>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_info_panel',
    'summary' => false
])
?>
<?php Pjax::end()?>

<?php
Modal::begin([
    'id' => 'activity-delete-modal',
    'header' => '<h2>Dealer</h2>',
    'footer' => Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal'])
        . PHP_EOL . Html::button('Delete', [
            'class' => 'btn btn-primary btn-modal-save',
            'id' => 'delete-role-model',
            'data-id' => '',
            'onClick' => new JsExpression('
                        var id=$("#delete-role-model").attr("data-id");
                        $.ajax({type:"post",url:"'.Url::to(['deactivate']).'",data:{id:id},success:function(){
                        $.pjax.reload({container:"#pjax-gridview",timeout:2e3}),
                        $("#activity-delete-modal").modal("hide")}});
                        ')
        ]),
]);

echo 'Are You Sure To Unsubscibe from this dealer';
Modal::end();
?>

<?php $this->registerJs('
jQuery(document).on("click",".deactivate-dealer",function(){
    var t=$(this).attr("data-id");
    $("#delete-role-model").attr("data-id",t),
    $("#activity-delete-modal").modal("show")
})
jQuery(document).on("click",".activate-dealer",function(){
        var t=$(this).attr("data-id");
        $.ajax({
        type:"post",url:"'. Url::to(['activate']) .'",
        data:{id:t},
        success:function(data){
            $.pjax.reload({container:"#pjax-gridview",timeout:2e3});
        }
        });
        return false;
        }
        )
');?>
