<?php

namespace auction\modules\admin\controllers;

use auction\components\Auction;
use auction\components\helpers\DatabaseHelper;
use Yii;
use auction\models\Auctions;
use auction\models\forms\SearchAuction;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuctionController implements the CRUD actions for Auctions model.
 */
class AuctionController extends CategoryController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'view' => ['post']
                ],
            ],
        ];
    }

    /**
     * Lists all Auctions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchAuction();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Auctions model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        $id=Auction::$app->request->post('id',0);

        if($id){

            return $this->renderPartial('view', [
                'model' => $this->findModel($id),
            ]);

        }

    }


    /**
     * Deletes an existing Auctions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id=Auction::$app->request->post('id',0);

        if($id){
            $model = $this->findModel($id);
            $model->status= DatabaseHelper::IN_ACTIVE;

            return $model->save();
        }

    }

    /**
     * Finds the Auctions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Auctions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $query=Auctions::find()->joinWith([
            'bidsTerms',
            'auctionsCriterias'
        ])->where([
           'auctions.id' => $id
        ]);

        $model=$query->one();

        if (($model = Auctions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
