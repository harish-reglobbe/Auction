<?php
/**
 * Created by PhpStorm.
 * User: Double H
 * Date: 30-08-2015
 * Time: 11:09 AM
 */
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="col-lg-4">
    <div class="<?php echo $model->status ? 'panel panel-success' : 'panel panel-danger'?>">
        <div class="panel-heading">
            <?= Html::a($model->name, Url::to(['dealer/auction/view' ,'id' => $model->primaryKey]))?>
        </div>
        <div class="panel-body">
            <div class="list-group">
                <?= DetailView::widget([
                    'model' => $model,
                    'template' => '<a href="#" class="list-group-item">{label}<span class="pull-right text-muted small"><em>{value}</em></span></a>',
                    'attributes' => [
                        'name',
                        'amount',
                        'create_date:date',
                    ]
                ])?>
            </div>
        </div>
        <div class="panel-footer">
        </div>
    </div>
    <!-- /.col-lg-4 -->
</div>
