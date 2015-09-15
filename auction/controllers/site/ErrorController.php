<?php

namespace auction\controllers\site;

use auction\components\Auction;

class ErrorController extends \yii\web\Controller
{

    public $layout = 'error';

    public function actionIndex(){

        $exception = Auction::$app->errorHandler->exception;

        $statusCode= $exception->statusCode;

        if (in_array($statusCode, [404,403,500])) {
            return $this->render($exception->statusCode);
        }else{
            return $this->render('error', ['exception' => $exception]);
        }

    }
}
