<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use auction\components\Auction;

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
    <link rel="stylesheet" type="text/css" href="resources/css/style.css" />
    <style>
        .error-page {
            color: #333;
            text-align: center;padding:0 10px;
        }
        .error-page img{margin:10px 0;max-width:100%;}
        .error-page h1 {
            font-size: 24px;
        }
        .error-page > p {
            font-weight: 300;font-size:16px;
        }
        .error-page p a{color:#0072dc;}
    </style>
</head>
<body><!--Add class cbp-spmenu-push-toright to this to display nav-->
<?php $this->beginBody() ?>
<section class="main-body">
    <?= $content ?>
</section>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

