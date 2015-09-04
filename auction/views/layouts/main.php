<?php

/* @var $this \yii\web\View */
/* @var $content string */

use auction\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Menu;
use auction\components\Auction;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Auction::$app->language ?>" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="<?= Auction::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand"><?= Auction::$app->name?></a>
        </div>
        <!-- /.navbar-header -->
        <?= Menu::widget([
            'options' => ['class' => 'nav navbar-top-links navbar-right'],
            'items' => [
                [
                    'url' => '#',
                    'template' => '<a class="dropdown-toggle" href="#" data-toggle="dropdown" ><b>'. Auction::$app->session->get('user.name') .'</b><i class="fa fa-user fa-fw"></i></a>',
                    'items' => [
                        ['label' => '<i class="fa fa-user fa-fw"></i>User Profile', 'url' => '#', 'options' => ['class' => false]],
                        ['label' => '<i class="fa fa-gear fa-fw"></i>Settings', 'url' => '#', 'options' => ['class' => false]],
                        ['label' => false, 'url' => false, 'options' => ['class' => 'divider']],
                        ['label' => '<i class="fa fa-sign-out fa-fw"></i>Logout</a>', 'url' => Url::to(['site/logout']), 'options' => ['class' => false]],
                    ],
                ],
            ],
            'itemOptions' => ['class' => 'dropdown'],
            'submenuTemplate' => "\n<ul class='dropdown-menu dropdown-user'>\n{items}\n</ul>\n",
            'encodeLabels' => false, //allows you to use html in labels
        ]); ?>

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <?= Menu::widget([
                    'options' => ['class' => 'nav', 'id' => 'side-menu'],
                    'items' => [
                        ['label' => '<i class="fa fa-dashboard fa-fw"></i>Dashboard', 'url' => Auction::createUrl('company/info')],
                        [
                            'template' => '<a class="active" href="#"><i class="fa fa-wrench fa-fw"></i>Auctions<span class="fa arrow"></span></a>',
                            'items' => [
                                ['label' => '<i class="fa fa-play-circle-o fa-fw"></i>List Auctions', 'url' => Auction::createUrl('company/auction')],
                                ['label' => '<i class="fa  fa-github-square fa-fw"></i>Add Auction', 'url' => Auction::createUrl('company/create-auction')],
                            ],
                        ],
                        [
                            'template' => '<a class="active" href="#"><i class="fa fa-wrench fa-fw"></i>Users<span class="fa arrow"></span></a>',
                            'items' => [
                                ['label' => '<i class="fa fa-play-circle-o fa-fw"></i>List Company Users', 'url' => Auction::createUrl('company/user')],
                                ['label' => '<i class="fa  fa-github-square fa-fw"></i>Dealers', 'url' => Auction::createUrl('company/dealer')],
                            ],
                        ],
                        [
                            'template' => '<a class="active" href="#"><i class="fa fa-wrench fa-fw"></i>Auction Lots<span class="fa arrow"></span></a>',
                            'items' => [
                                ['label' => '<i class="fa fa-play-circle-o fa-fw"></i>Lots', 'url' => Auction::createUrl('company/lots')],
                                ['label' => '<i class="fa fa-play-circle-o fa-fw"></i>Add Products In Lot', 'url' => Auction::createUrl('company/lot-product')],
                            ],
                        ],
                        [
                            'template' => '<a class="active" href="#"><i class="fa fa-wrench fa-fw"></i>Products<span class="fa arrow"></span></a>',
                            'items' => [
                                ['label' => '<i class="fa fa-play-circle-o fa-fw"></i>List Products', 'url' => Auction::createUrl('company/product')],
                                ['label' => '<i class="fa fa-play-circle-o fa-fw"></i>Upload CSV', 'url' => Auction::createUrl('company/upload-csv')],
                                ['label' => '<i class="fa fa-play-circle-o fa-fw"></i>Create Product Cofig', 'url' => Auction::createUrl('company/product-config')],
                            ],
                        ],
                        [
                            'template' => '<a class="active" href="#"><i class="fa fa-wrench fa-fw"></i>Setting<span class="fa arrow"></span></a>',
                            'items' => [
                                ['label' => '<i class="fa fa-play-circle-o fa-fw"></i>Update Info', 'url' => Auction::createUrl('company/edit')],
                            ],
                        ],
                        ['label' => '<i class="fa fa-sign-out fa-fw"></i>Sign Out', 'url' => Auction::createUrl('site/logout')],
                    ],
                    'encodeLabels' => false, //allows you to use html in labels,
                    'submenuTemplate' => "\n<ul class='nav nav-second-level'>\n{items}\n</ul>\n",
                ]);  ?>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
    <?= $content ?>
        </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

