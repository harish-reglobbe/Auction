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
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-3">
            </div>
            <div class="col-xs-9 text-right">
                <div class="huge"><?= $model?></div>
                <div></div>
            </div>
        </div>
    </div>
    <a href="">
        <div class="panel-footer">
            <span class="pull-left">View Details</span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
        </div>
    </a>
</div>
