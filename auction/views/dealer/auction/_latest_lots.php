<?php
/**
 * Created by PhpStorm.
 * User: Double H
 * Date: 06-09-2015
 * Time: 12:12 PM
 *
 * _view for List View For Latest Company Auction Section in index.php

 */
use auction\components\Auction;

?>

<ul class="chat">
    <li class="right clearfix">
        <div class="chat-body clearfix">
            <div class="header">
                <small class=" text-muted">
                    <i class="fa fa-clock-o fa-fw"></i> <?= $model->lot_size?> Products
                </small>
            </div>
            <h5>
                <strong class="primary-font"><?= $model->name ?></strong>
            </h5>
        </div>
    </li>
</ul>
