<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use auction\components\helpers\DatabaseHelper;
use auction\components\Auction;

/* @var $this yii\web\View */
/* @var $model auction\models\Users */

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
            'user_role',
            [
                'label' => 'is_active',
                'value' => DatabaseHelper::GetStatus($model->is_active)
            ],
            'created_at:date',
        ],
    ]) ?>

    <?php

    $common_attribute=['name','address'];
    if($model->dealers !== null){
        $attributes=['contact','city'];
        $attributes[] =[
            'label' => 'Profile Pic',
            'format' => 'html',
            'value' => Auction::showImage('dealer' , $model->profile_pic)
        ];
        $detailView=$model->dealers;
    }
    elseif($model->company !== null){
        $attributes=['domain','contact','description'];
        $attributes[] =[
            'label' => 'Profile Picture',
            'format' => 'html',
            'value' => Auction::showImage('company' , $model->company->logo_image)
        ];
        $detailView=$model->company;
    }

    ?>

    <?= DetailView::widget([
        'model' => $detailView,
        'attributes' => ArrayHelper::merge($common_attribute,$attributes)
    ]); ?>
</div>
