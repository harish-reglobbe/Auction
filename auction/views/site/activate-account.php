<?php
/* @var $this yii\web\View */
use auction\components\Auction;
use yii\bootstrap\Alert;

?>
<h1>Activation Status</h1>

<?php if (Auction::$app->session->hasFlash('activate-status')): ?>

    <?php Alert::begin(['options' => ['class' => 'alert-success',]]);
    echo Auction::$app->session->getFlash('activate-status');
    Alert::end();
    ?>

<?php endif; ?>
