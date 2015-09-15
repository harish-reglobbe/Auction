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
class AuctionController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'update' => ['post'],
                    'view' => ['post'],
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
     * Updates an existing Brands model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $id=Auction::$app->request->post('id');
        if($id){
            $model = Auctions::findOne($id);
            if ($model->load(Auction::$app->request->post()) && $model->save()) {
                return 'Successfully Updated';
            } else {
                return $this->renderPartial('update', [
                    'model' => $model,
                ]);
            }
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
        $model = Auctions::find()->joinWith([
            'bidsTerms',
            'auctionsCriterias'
        ])->where([
           'auctions.id' => $id
        ])->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
