<?php

namespace auction\modules\admin\controllers;
use auction\components\Auction;
use auction\models\Brands;
use auction\models\forms\SearchBrand;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * BrandController implements the CRUD actions for Brands model.
 */
class BrandController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'view' => ['post'],
                    'create' => ['post'],
                    'update' => ['post']
                ],
            ],
        ];
    }

    /**
     * Lists all Brands models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchBrand();
        $dataProvider = $searchModel->search(Auction::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Brands model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        $id=Auction::$app->request->post('id');
        if($id) {
            return $this->renderPartial('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Brands model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Brands();
        if ($model->load(Auction::$app->request->post()) && $model->save()) {
            return 'Success';
        } else {
            return $this->renderPartial('_form', [
                'model' => $model,
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
            $model = $this->findModel($id);

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
     * Finds the Brands model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Brands the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Brands::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
