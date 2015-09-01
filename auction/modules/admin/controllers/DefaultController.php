<?php

namespace auction\modules\admin\controllers;

use auction\components\Auction;
use auction\models\Auctions;
use auction\models\Companies;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
