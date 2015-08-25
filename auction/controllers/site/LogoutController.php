<?php

namespace auction\controllers\site;

use auction\components\Auction;

class LogoutController extends \yii\web\Controller
{
    public function actionIndex()
    {
        Auction::$app->user->logout();

        return $this->goHome();
    }

}
