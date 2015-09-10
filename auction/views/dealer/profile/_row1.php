<?php

use auction\components\Auction;
/**
 * created by phpstorm.
 * user: reglobbe
 * date: 26/8/15
 * time: 2:48 pm
 *
 * _view for list view of info.php
 *
 */

switch ($key){
    case 'dealerSecurity':
        $url='dealer/payment';$panelClass='panel-primary';$text='My Security Amount';$model.= ' &#8377  ';
        break ;

    case 'dealerCompanies':
        $url='dealer/company';$panelClass='panel-red';$text='My Companies';
        break ;

    case 'dealerAuctions':
        $url=false;$panelClass='panel-green';$text='My Auctions';
        break;

    default:
        $url='#';$panelClass='panel-red';$text='View';
}
?>

<div class="panel <?= $panelClass?>">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-3">
            </div>
            <div class="col-xs-9 text-right">
                <div class="huge"><?= $model?></div>
                <div><?= $text ?></div>
            </div>
        </div>
    </div>
    <a href="<?= Auction::$app->urlManager->createAbsoluteUrl($url)?>">
        <div class="panel-footer">
            <span class="pull-left">View Details</span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
        </div>
    </a>
</div>
