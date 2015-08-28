<?php

namespace auction\controllers\company;

use auction\components\Auction;
use auction\components\helpers\AccessRule;
use yii\filters\AccessControl;
use yii\web\HttpException;
use auction\models\Companies;

class InfoController extends \yii\web\Controller
{
    //Behaviour to Apply Access Filtering
   /* public function behaviors(){
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
    }*/

    public function actionIndex()
    {
        $model=$this->loadModel();

        return $this->render('info',[
            'model' => $model
        ]);
    }

    /**
     * Get Company Info
     *
     * todo need to learn relational stat query worst method ever
     */
    protected function loadModel(){

        /**
         * Load All Related Models Of Users
         * having userId is logged in dealer user Id
         */
        $query= Companies::find()->with([
            'user' =>function($query){
                $query->andWhere(['id' => Auction::$app->user->id]);
            },
            'auctions' => function($query){
                $query->asArray();
            },
            'companyUsers' => function($query){
                $query->asArray();
            }
        ])->where([
            'id' => Auction::$app->session->get('user.company')
        ]);

        $model=$query->one();

        if($model === null){
            throw new HttpException(400, 'Not a Valid Company');
        }

        return $model;
    }

}
