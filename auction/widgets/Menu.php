<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 9/9/15
 * Time: 11:51 AM
 */

namespace auction\widgets;


use auction\components\Auction;
use auction\components\helpers\DatabaseHelper;

class Menu extends \yii\widgets\Menu{

    public function init()
    {

        $_role = Auction::userRole();

        if ($_role == DatabaseHelper::COMPANY_ADMIN) {

            $this->items = [
                ['label' => '<i class="fa fa-dashboard fa-fw"></i>Dashboard', 'url' => Auction::createUrl('company/info')],
                [
                    'template' => '<a class="active" href="#"><i class="fa fa-wrench fa-fw"></i>Auctions<span class="fa arrow"></span></a>',
                    'items'    => [
                        ['label' => '<i class="fa fa-play-circle-o fa-fw"></i>List Auctions', 'url' => Auction::createUrl('company/auction')],
                        ['label' => '<i class="fa  fa-github-square fa-fw"></i>Add Auction', 'url' => Auction::createUrl('company/auction/create')],
                    ],
                ],
                [
                    'template' => '<a class="active" href="#"><i class="fa fa-wrench fa-fw"></i>Users<span class="fa arrow"></span></a>',
                    'items'    => [
                        ['label' => '<i class="fa fa-play-circle-o fa-fw"></i>List Company Users', 'url' => Auction::createUrl('company/user')],
                        ['label' => '<i class="fa  fa-github-square fa-fw"></i>Dealers', 'url' => Auction::createUrl('company/dealer')],
                    ],
                ],
                [
                    'template' => '<a class="active" href="#"><i class="fa fa-wrench fa-fw"></i>Auction Lots<span class="fa arrow"></span></a>',
                    'items'    => [
                        ['label' => '<i class="fa fa-play-circle-o fa-fw"></i>Lots', 'url' => Auction::createUrl('company/lots')],
                        ['label' => '<i class="fa fa-play-circle-o fa-fw"></i>Add Products In Lot', 'url' => Auction::createUrl('company/lot-product')],
                    ],
                ],
                [
                    'template' => '<a class="active" href="#"><i class="fa fa-wrench fa-fw"></i>Products<span class="fa arrow"></span></a>',
                    'items'    => [
                        ['label' => '<i class="fa fa-play-circle-o fa-fw"></i>List Products', 'url' => Auction::createUrl('company/product')],
                        ['label' => '<i class="fa fa-play-circle-o fa-fw"></i>Upload CSV', 'url' => Auction::createUrl('company/upload-csv')],
                        ['label' => '<i class="fa fa-play-circle-o fa-fw"></i>Create Product Cofig', 'url' => Auction::createUrl('company/product-config')],
                    ],
                ],
                [
                    'template' => '<a class="active" href="#"><i class="fa fa-wrench fa-fw"></i>Setting<span class="fa arrow"></span></a>',
                    'items'    => [
                        ['label' => '<i class="fa fa-play-circle-o fa-fw"></i>Update Info', 'url' => Auction::createUrl('company/edit')],
                    ],
                ],
            ];
        } elseif ($_role == DatabaseHelper::DEALER) {

            $this->items = [
                ['label' => '<i class="fa fa-dashboard fa-fw"></i>Dashboard', 'url' => Auction::createUrl('dealer/profile')],
                ['label' => '<i class="fa fa-dashboard fa-fw"></i>Companies', 'url' => Auction::createUrl('dealer/company')],
                ['label' => '<i class="fa fa-dashboard fa-fw"></i>Payment', 'url' => Auction::createUrl('dealer/payment')],
                [
                    'template' => '<a class="active" href="#"><i class="fa fa-wrench fa-fw"></i>Setting<span class="fa arrow"></span></a>',
                    'items'    => [
                        ['label' => '<i class="fa fa-play-circle-o fa-fw"></i>Update Info', 'url' => Auction::createUrl('dealer/edit-profile')],
                    ],
                ],
            ];
        }

       $this->items[] = ['label' => '<i class="fa fa-sign-out fa-fw"></i>Sign Out', 'url' => Auction::createUrl('site/logout')];

        parent::init();
    }
}