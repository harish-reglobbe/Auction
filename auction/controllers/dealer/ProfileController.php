<?php

namespace auction\controllers\dealer;

use auction\components\controllers\DealerController;
use auction\models\Dealers;
use yii\web\HttpException;
use auction\components\Auction;

class ProfileController extends DealerController
{

    public function actionIndex()
    {
        $model=$this->loadModel();

        return $this->render('profile',[
            'model' => $model
        ]);
    }

    /**
     * Get Dealer Info
     */
    protected function loadModel(){

        /**
         * Load All Related Models Of Users
         * having userId is logged in dealer user Id
         */
        $query= Dealers::find()->joinWith([
            'user0',
        ])->where([
            'user' => Auction::$app->user->id
        ]);

        $model=$query->one();

        if($model === null){
            throw new HttpException(400, 'Not a Valid Dealer');
        }
        return $model;
    }
}
