<?php

namespace auction\modules\admin\controllers;

use auction\components\Auction;
use auction\models\forms\SearchProduct;
use auction\modules\admin\components\CSVColumns;
use auction\modules\admin\components\ParseCSV;
use auction\modules\admin\components\ReadCsv;
use Yii;
use auction\models\Products;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Products model.
 */
class ProductController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
               //     'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel =new SearchProduct();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return "Success";
        } else {
            return $this->renderPartial('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'Success';
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete()
    {

        $id=Auction::$app->request->post('id');

        if($id) {
            Products::deleteAll($id);
        }
       // return $this->redirect(['index']);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Upload Products To MongoDb
     */
    public function actionUpload(){
        $model= new Products();

        $columns= CSVColumns::ProductCSVColumn();

        if(isset($_POST['Products'])){
            $fileInstance=UploadedFile::getInstance($model, 'productCSV');
            $csvData= new ReadCsv($fileInstance);

            if($csvData->noOfColumns !== $columns->count)
                throw new HttpException(400, 'Check Your CSV Upload File Columns');

            $model->uploadCsvFile($csvData->data);

        }

        return $this->render('upload',[
            'model' => $model,
            'columns' => $columns
        ]);
    }

    /**
     * Download Sample Excel
     */
    public function actionSample(){
        $csv = new ParseCSV();

        $columns= CSVColumns::ProductCSVColumn(true);
        $csv->output('Products.csv', [], $columns, ',');
    }
}
