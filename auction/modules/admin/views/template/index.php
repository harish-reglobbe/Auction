<?php

use auction\widgets\GridView;

$this->title = 'Templates';
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Templates</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button class="btn btn-info" type="button" id="create-modal">+ Add More Templates</button>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'name',
                            'type',
                            'text:ntext',
                            [
                                'class' => 'auction\widgets\grid\DatePickerColumn',
                                'dateColumn' => 'created_at'
                            ],
                            ['class' => 'auction\widgets\grid\StatusColumn'],

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
</div>
<!-- /#page-wrapper -->

