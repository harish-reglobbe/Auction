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
        $model= Companies::find()->joinWith('auctions',true,'RIGHT JOIN')->count();

        dump($model);
    }
}
