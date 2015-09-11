<?php

namespace auction\controllers\site;

use auction\components\Auction;

class ErrorController extends \yii\web\Controller
{

    public $layout = 'login';

    public function actionIndex(){

        $exception = Auction::$app->errorHandler->exception;

        return $this->render('error', ['exception' => $exception]);
    }
}
