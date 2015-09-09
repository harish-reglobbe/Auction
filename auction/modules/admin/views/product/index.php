<?php

use auction\widgets\grid\GridView;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel auction\models\forms\SearchBrand */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title='Products';
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
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

