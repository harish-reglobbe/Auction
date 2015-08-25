<?php

namespace auction\controllers\company;

use auction\components\Auction;
use auction\components\helpers\AccessRule;
use yii\filters\AccessControl;
use auction\components\helpers\DatabaseHelper;
use auction\models\Companies;

class InfoController extends \yii\web\Controller
{
    //Behaviour to Apply Access Filtering
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [
                            DatabaseHelper::COMPANY_ADMIN,
                        ],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model=$this->loadModel();

        return $this->render('//company/profile',[
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
            'user'
        ])->where([
            'company_users.user' => Auction::$app->user->id
        ]);

        $model=$query->one();

        if($model === null){
            throw new HttpException(400, 'Not a Valid Company');
        }

        return $model;
    }

}
