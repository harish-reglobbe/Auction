<?php

namespace auction\controllers\site;

use auction\components\Auction;

class ErrorController extends \yii\web\Controller
{

    public $layout = 'error';

    public function actionIndex(){

        $exception = Auction::$app->errorHandler->exception;

        if ($exception !== null) {
            return $this->render($exception->statusCode);
        }
    }
}
