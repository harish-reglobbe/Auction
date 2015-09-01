<?php

/* @var $this \yii\web\View */
/* @var $content string */

use auction\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\NavBar;
use auction\components\Auction;
use yii\bootstrap\Nav;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php $this->head() ?>
</head>
<body class="bgwhite">
<?php $this->beginBody() ?>

<?php
NavBar::begin([
    'brandLabel' => '<img alt="" src="/Auction/auction/web/images/logo-reglobe.png">',
    'brandUrl' => '#',
    'renderInnerContainer' => false,
    'options' => [
        'class' => 'navbar navbar-default navbar-static-top',
        'style' => 'margin-bottom: 0',
        'role' => 'navigation',
        'id' => false
    ],
]);

echo Nav::widget([
      'items' => [
          ['label' => '<div class="Partner-logo navbar-brand">Apple Exchange Program </div>', 'url' => Auction::createUrl('site/login')],
      ],
    'encodeLabels' => false,
    'options' => [
        'class' => 'nav navbar-top-links navbar-right',
    ]
  ]);

NavBar::end();
?>

<div class="container">
    <?= $content?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
