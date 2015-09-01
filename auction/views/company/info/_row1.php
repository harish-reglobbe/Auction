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
    case 'companyUsers':
        $url='company/user';$panelClass='panel-primary';$text='View Users';
        break ;

    case 'companyAuctions':
        $url='company/auction';$panelClass='panel-red';$text='View Auctions';
        break ;

    case 'companyDealers':
        $url='company/dealer';$panelClass='panel-green';$text='View Dealers';
        break ;

    default:
        $url='#';$panelClass='panel-red';$text='View Auctions';
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
