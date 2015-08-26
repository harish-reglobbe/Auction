<?php

namespace auction\controllers\company;

use auction\components\Auction;
use auction\models\Companies;
use yii\web\HttpException;
use yii\filters\AccessControl;
use auction\components\helpers\DatabaseHelper;
use auction\components\helpers\AccessRule;

class UserProfileController extends \yii\web\Controller
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
                            DatabaseHelper::DEALER,
                            DatabaseHelper::COMPANY_ADMIN
                        ],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model= $this->loadModel();

        return $this->render('//company/user-profile',[
            'model' => $model
        ]);
    }

    /**
     * Get Company Info
     */
    protected function loadModel(){

        /**
         * Load All Related Models Of Users
         * having userId is logged in dealer user Id
         */

        $query= Companies::find()->joinWith([
            'user' => function($query){
                 $query->where([
                    'users.id' => Auction::$app->user->id
                ]);
            }
        ]);

        $model=$query->one();

        if($model === null){
            throw new HttpException(400, 'Not a Valid Dealer');
        }
        return $model;
    }

}
