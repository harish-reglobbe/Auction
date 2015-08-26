<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 14/8/15
 * Time: 3:06 PM
 */

use yii\widgets\DetailView;
use yii\helpers\Html;

$this->title = 'Company User Profile';
?>

<h1><?= $this->title; ?></h1>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'user.name',
        'user.mobile',
        'user.email',
    ],
]); ?>

<?= Html::a('Update Profile', '#', ['class' => 'btn btn-success', 'id' => 'update-profile']) ?>
