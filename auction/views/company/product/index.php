<?php

use auction\widgets\grid\GridView;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel auction\models\forms\SearchBrand */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title='Company::Products';
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
            <div class="panel-heading">
                <a href="<?= Url::to(['create'])?>" class="btn btn-info">+ Add More Products</a>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\CheckboxColumn'],
                        'name',
                        [
                            'class' => 'auction\widgets\grid\ImageColumn',
                            'path' => 'products'
                        ],
                        'brand0.name',
                        'category0.name',
                        'prize',
                        'condition',
                        [
                            'class' => 'auction\components\helpers\ActionColumn',
                            'template' => '{view}{update}'
                        ],
                    ],
                ]); ?>

            </div>
            <?= Html::button('Delete Selected',['class' => 'btn btn-info', 'onclick' => new JsExpression('
                var id = $("#dataTables-example").yiiGridView("getSelectedRows");
                alert(id);
                $.ajax({
                type : "post",
                url  :  "'. Url::to(['delete']) .'",
                data : {id : id},
                success : function(data){
                        $.pjax.reload({container:"#pjax-gridview",timeout:2e3});
                }
                });
            ')]);?>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php
$this->registerJs('
jQuery(document).on("pjax:success", "#brand-form",  function(event){$.pjax.reload({container:"#pjax-gridview",timeout:2e3}),$("#activity-modal").modal("hide")});
jQuery(document).pjax("#brand-form a", "#brand-form", {"push":false,"replace":false,"timeout":false,"scrollTo":false});
jQuery(document).on("submit", "#brand-form form[data-pjax]", function (event) {jQuery.pjax.submit(event, "#brand-form", {"push":false,"replace":false,"timeout":false,"scrollTo":false});});
    ');
?>

