<?php

namespace auction\modules\admin\controllers;

use auction\components\Auction;
use auction\components\helpers\DatabaseHelper;
use auction\models\Categories;
use auction\models\forms\SearchCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Categories model.
 */
class CategoryController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'view' => ['post'],
                    'update' => ['post'],
                    'create' => ['post']
                ],
            ],
        ];
    }

    /**
     * Lists all Categories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchCategory();
        $dataProvider = $searchModel->search(Auction::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Categories model.
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
     * Creates a new Categories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Categories();
        if ($model->load(Auction::$app->request->post()) && $model->save()) {
            return 'Success';
        } else {
            return $this->renderPartial('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Categories model.
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
                return $this->renderPartial('_form', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Finds the Categories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categories::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
