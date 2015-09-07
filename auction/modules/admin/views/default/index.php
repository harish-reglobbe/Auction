<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 14/8/15
 * Time: 3:06 PM
 */

use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\data\ArrayDataProvider;
use auction\components\helpers\BootstrapHelper;

$this->title='Admin Dashboard';
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Admin Dashboard</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_row1',
    'summary' => false,
    'itemOptions' => [
        'class' => 'col-lg-3 col-md-6'
    ],
    'options' => [
        'class' => 'row',
        'id' => false
    ]
])?>
<!-- /.row -->