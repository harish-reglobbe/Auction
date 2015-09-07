<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 14/8/15
 * Time: 3:06 PM
 */

use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;

$this->title = 'Dealer Profile';
?>

<h1><?= $this->title; ?></h1>

<?= DetailView::widget([
    'model' => $model,
    'formatter' => [
        'class' => 'yii\i18n\Formatter',
        'nullDisplay' => ''
    ],
    'attributes' => [
        'user0.name',
        'city',
        'user0.email',
        'contact',
        'dealerSecurities.security'
    ],
]); ?>

<?= Html::a('Update Profile', '#', ['class' => 'btn btn-success', 'id' => 'update-profile']) ?>

<h2>Dealer Preferences</h2>

<?php $dataProvider = new ArrayDataProvider([
    'allModels' => $model->dealerPreferences,
    'pagination' => [
        'pageSize' => 4,
    ],
]); ?>
<?= Html::a('Add Prefences', '#', ['class' => 'btn btn-success', 'id' => 'add-prefences']) ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'header' => 'Category Name',
            'value' => 'category0.name',
        ],
        [
            'header' => 'Brand Name',
            'value' => 'brand0.name'
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'view' => function ($model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '#', [
                        'class' => 'prefeneces-view-link',
                        'data-id' => $model,
                    ]);
                }
            ]
        ]
    ]
]) ?>

<h2> Dealer Companies</h2>

<?php
$dataProvider = new ArrayDataProvider([
    'allModels' => $model->dealerCompanies,
    'pagination' => [
        'pageSize' => 10,
    ],
]);
?>
<?= Html::a('Add Company', '#', ['class' => 'btn btn-success', 'id' => 'add-company']) ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'company0.name',
        'company0.description',
        'status',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}{delete}',
        ]

    ]
]) ?>
