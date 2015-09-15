<?php

use auction\widgets\grid\GridView;
use yii\helpers\Html;
use auction\components\helpers\DatabaseHelper;

/* @var $this yii\web\View */
/* @var $searchModel auction\models\forms\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Admin::Users';
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Users</h1>
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
                        ['class' => 'yii\grid\SerialColumn'],

                        'name',
                        'mobile',
                        [
                            'header' => 'User Role',
                            'value' => 'user_role',
                            'filter' => Html::activeDropDownList($searchModel,'user_role',DatabaseHelper::UserRole(),['class' => 'form-control','prompt' => '-------']),
                        ],
                        [
                            'class' => 'auction\widgets\grid\DatePickerColumn',
                            'dateColumn' => 'created_at'
                        ],
                        ['class' => 'auction\widgets\grid\StatusColumn'],

                        [
                            'class' => 'auction\widgets\grid\ActionColumn',
                            'template' => '{view}{update}'
                        ],
                    ],
                ]); ?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php
$this->registerJs('
jQuery(document).on("pjax:success", "#brand-form",  function(event){
    $.pjax.reload({
    container:"#pjax-gridview",timeout:2e3
    }),$("#activity-modal").modal("hide")}
);
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
        "scrollTo":false});
});
');
?>