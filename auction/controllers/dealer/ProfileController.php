<?php

namespace auction\controllers\dealer;

use auction\components\helpers\DatabaseHelper;
use auction\models\Dealers;
use yii\web\HttpException;
use auction\components\Auction;
use auction\components\helpers\AccessRule;
use yii\filters\AccessControl;

class ProfileController extends \yii\web\Controller
{
    //Behaviour to Apply Access Filtering
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                // We will override the default rule config with the new AccessRule class
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [
                            DatabaseHelper::DEALER
                        ],
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $model=$this->loadModel();

        return $this->render('//dealer/profile',[
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
            'dealerSecurities',
            'dealerPreferences' => function($query){
                $query->with([
                    'category0',
                    'brand0'
                ]);
            },
            'dealerCompanies' => function($query){
                $query->joinWith([
                    'company0',
                    'dealerCompanyPreferences' => function($query){
                    }
                ]);
            },
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
