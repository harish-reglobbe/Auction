<?php

use auction\widgets\grid\GridView;
use yii\helpers\Html;
use auction\components\Auction;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel auction\models\forms\SearchBrand */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title='Add Lot Products';
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Products</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\CheckboxColumn'],
                        [
                            'value' => 'name',
                            'filter' => Html::activeTextInput($searchModel,'name',['class' => 'form-control'])
                        ],
                        [
                            'class' => 'auction\widgets\grid\ImageColumn',
                            'path' => 'products'
                        ],
                        [
                            'class' => 'auction\widgets\grid\DatabaseColumn',
                            'modelClass' => 'auction\models\Categories',
                            'relationName' => 'category0',
                            'filterAttribute' => 'category'
                        ],
                        [
                            'class' => 'auction\widgets\grid\DatabaseColumn',
                            'modelClass' => 'auction\models\Brands',
                            'relationName' => 'brand0',
                            'filterAttribute' => 'brand'
                        ],
                        'prize',
                        'condition',
                    ],
                ]); ?>

            </div>
            <?= Html::button('Add Selected Products To Lots',['class' => 'btn btn-info', 'id' => 'add-lots-products']);?>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php
Modal::begin([
    'id' => 'activity-modal',
    'header' => '<h2>Add Lots Products</h2>',
    'footer' => Html::button('Close', ['class' => 'btn btn-info', 'data-dismiss' => 'modal']),
]);

Modal::end();

Modal::begin([
    'id' => 'new-form-modal',
    'size' => Modal::SIZE_SMALL,
    'header' => '<h2>Add A New Lot</h2>',
    'footer' => Html::button('Close', ['class' => 'btn btn-info', 'data-dismiss' => 'modal']),
]);

Modal::end();
?>
<?php $this->registerJs('
jQuery(document).on("click" , "#add-lots-products",function(){
    if($("#dataTables-example").yiiGridView("getSelectedRows") == ""){
        alert("Please Select At least one Product")
        return false;
    }
    $.ajax({
    type: "get",
    url: "'. Auction::createUrl('company/lots/auction-not-assigned') .'",
    success : function(t){
        $("#activity-modal").find(".modal-body").html(t);
        $("#activity-modal").modal("show");
    }
    });
});
jQuery("#lot-table-grid").yiiGridView({"filterUrl":"\/Auction\/auction\/web\/index.php?r=company%2Flots%2Fauction-not-assigned","filterSelector":"#lot-table-grid-filters input, #lot-table-grid-filters select"});
jQuery(document).pjax("#lots-pjax-gridview a", "#lots-pjax-gridview", {"push":false,"replace":false,"timeout":false,"scrollTo":false});
jQuery(document).on("submit", "#lots-pjax-gridview form[data-pjax]", function (event) {jQuery.pjax.submit(event, "#lots-pjax-gridview", {"push":false,"replace":false,"timeout":false,"scrollTo":false});});
jQuery(document).on("click",".view-modal",function(){var t=$(this).attr("data-id");$.ajax({type:"post",url:"/Auction/auction/web/index.php?r=company%2Flots%2Fview",data:{id:t},success:function(t){$("#activity-modal").find(".modal-body").html(t),$("#activity-modal").modal("show")}})}),jQuery(document).on("click",".update-modal",function(){var t=$(this).attr("data-id");$.ajax({type:"post",url:"/Auction/auction/web/index.php?r=company%2Flots%2Fupdate",data:{id:t},success:function(t){$("#activity-modal").find(".modal-body").html(t),$("#activity-modal").modal("show")}})}),jQuery(document).on("click","#create-modal",function(){$.ajax({type:"post",url:"/Auction/auction/web/index.php?r=company%2Flots%2Fcreate",success:function(t){$("#activity-modal").find(".modal-body").html(t),$("#activity-modal").modal("show")}})})
jQuery(document).on("click","#save-lot-id",function(){
    var id= $("input[name=radio-box-column]:checked").val()
    if(id == "" || id == null){
        alert("Please Select a lot");
        return false;
    }
    var selectedId= $("#dataTables-example").yiiGridView("getSelectedRows");
    console.log(id);
    console.log(selectedId);
    $.ajax({
        type : "post",
        url : "'. Auction::createUrl('company/lot-product/update') .'",
        data: {id:id,selectedId:selectedId},
        success: function(t){
            $("#activity-modal").modal("hide");
            $.pjax.reload({container:"#pjax-gridview",timeout:2e3})
        }
    });
    return false;
});
jQuery(document).on("click" ,"#create-lot-modal",function(){
    $("#activity-modal").modal("hide");
    $.ajax({
    type: "post",
    url: "'. Auction::createUrl('company/lots/create') .'",
    success : function(t){
        $("#new-form-modal").find(".modal-body").html(t);
        $("#new-form-modal").modal("show");
    }
    });
    return false;
});
jQuery(document).on("pjax:success", "#brand-form",  function(event){$("#new-form-modal").modal("hide");});
jQuery(document).pjax("#brand-form a", "#brand-form", {"push":false,"replace":false,"timeout":false,"scrollTo":false});
jQuery(document).on("submit", "#brand-form form[data-pjax]", function (event) {jQuery.pjax.submit(event, "#brand-form", {"push":false,"replace":false,"timeout":false,"scrollTo":false});});
')?>
