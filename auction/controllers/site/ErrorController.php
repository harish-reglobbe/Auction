<?php

namespace auction\controllers\site;

use auction\components\Auction;
use yii\base\UnknownMethodException;
use yii\web\ErrorAction;
use yii\console\ErrorHandler;

class ErrorController extends \yii\web\Controller
{

        public function actionIndex(){

            $exception = Auction::$app->errorHandler->exception;


            if ($exception !== null) {
                return $this->render('error', ['message' => $exception->getMessage(), 'name' => $exception->statusCode]);
            }
        }
}
