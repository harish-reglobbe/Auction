<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Users */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'email:email',
            'mobile',
            'last_login:date',
            'last_login_ip',
            'user_role',
            'is_active',
            'profile_pic',
        ],
    ]) ?>

    <?php if($model->dealers):?>

        <?php $attribute=['name','city','contact','address'];?>
        <?php $infoModel=$model->dealers;?>

        <?php else:?>

        <?php $attribute=['name','domain','contact','description','address',]?>
        <?php $infoModel=$model->companies->company0;?>

    <?php endif;?>

    <h1>Other Details</h1>

    <?= DetailView::widget([
        'model' => $infoModel,
        'attributes' => $attribute
    ]) ?>

</div>
