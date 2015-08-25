<?php

namespace auction\controllers\site;

use auction\components\Auction;
use yii\web\ErrorAction;

class ErrorController extends \yii\web\Controller
{

        public function actionIndex(){

            $exception = Auction::$app->errorHandler->exception;


            if ($exception !== null) {
                return $this->render('error', ['message' => $exception->getMessage(), 'name' => $exception->statusCode]);
            }
        }
}
