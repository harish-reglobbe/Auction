<?php
/**
 * Created by PhpStorm.
 * User: Double H
 * Date: 30-08-2015
 * Time: 11:09 AM
 */
use yii\widgets\DetailView;
?>

<div class="col-lg-4">
    <div class="<?php echo $model->is_active ? 'panel panel-success' : 'panel panel-danger'?>">
        <div class="panel-heading">
            <?= $model->company0->name?>
        </div>
        <div class="panel-body">
            <div class="list-group">
                <?= DetailView::widget([
                    'model' => $model->company0,
                    'template' => '<a href="#" class="list-group-item">{label}<span class="pull-right text-muted small"><em>{value}</em></span></a>',
                    'attributes' => [
                        'name',
                        'domain',
                        'contact',
                    ]
                ])?>
            </div>
        </div>
        <div class="panel-footer">
            <button class="btn btn-info edit-preferences" type="button" data-id="<?php echo $model->primaryKey ?>">Edit Preferences
            </button>
            <?php if($model->is_active):?>
                <button class="btn btn-danger deactivate-company" type="button" style="float: right" data-id="<?php echo $model->primaryKey ?>">De-Activate
            </button>
            <?php endif;?>
        </div>
    </div>
    <!-- /.col-lg-4 -->
</div>
