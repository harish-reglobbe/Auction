<?php

namespace auction\controllers\company;

use auction\components\Auction;
use auction\components\EventHandler;
use auction\components\Events;
use auction\components\helpers\DatabaseHelper;
use auction\models\Lots;
use Yii;
use auction\models\Auctions;
use auction\models\forms\SearchAuction;
use yii\base\Event;
use yii\base\Exception;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use auction\models\forms\CreateAuction;

/**
 * AuctionController implements the CRUD actions for Auctions model.
 */
class AuctionController extends \auction\components\controllers\Controller
{
    public $roles = [DatabaseHelper::COMPANY_ADMIN , DatabaseHelper::COMPANY_USER];
    public $roleBaseActions = ['index' , 'view' ,'create' , 'delete' ,'update'];

    public $verbs = [
        'view' => ['get'],
        'index' => ['get'],
        'deactivate' => ['post'],
        'activate' => ['post'],
        'update' => ['get', 'post']
    ];

    /**
     * Lists all Auctions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchAuction();
        $dataProvider = $searchModel->companyAuction(Yii::$app->request->queryParams);

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
    public function actionView($id)
    {
        $model = Auctions::find()->joinWith([
            'bidsTerms',
            'auctionsCriterias',
            'company0',
            'auctionPreferences' => function($query){
                $query->joinWith(['category0','brand0']);
            }
        ])->where([
            'auctions.id' => $id ,
            'auctions.company' => Auction::company()]
        )->one();

        if($model == null){
            throw new HttpException(404 , 'Not Found');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Auctions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CreateAuction();

        if ($model->load(Auction::$app->request->post())) {
            $id= $model->save();
            return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Auctions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     *
     * @throws Exception 404 if invalid data provided
     */
    public function actionUpdate($id)
    {
        $model = Auctions::find()->joinWith([
            'bidsTerms',
            'auctionsCriterias',
            'auctionPreferences'
        ])->where([
            'auctions.id' => $id
        ])->one();

        if($model === null){
            throw new HttpException(404 ,' Not A valid Auction');
        }

        $post = Auction::post();

        if ($model->load($post) && $model->bidsTerms->load($post) && $model->auctionsCriterias->load($post) && $model->auctionPreferences->load($post)) {

            if($model->save() && $model->bidsTerms->save() && $model->auctionsCriterias->save() && $model->auctionPreferences->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Auctions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = Auctions::findOne($id);
        $model->status = DatabaseHelper::IN_ACTIVE;

        if($model->save()){
            return $this->redirect(['index']);
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
        if (($model = Auctions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
