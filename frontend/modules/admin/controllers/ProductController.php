<?php

namespace frontend\modules\admin\controllers;

use frontend\components\Reglobe;
use frontend\modules\admin\components\CSVColumns;
use frontend\modules\admin\components\ParseCSV;
use frontend\modules\admin\components\ReadCsv;
use Yii;
use frontend\models\Products;
use frontend\models\forms\ProductSearchForm;
use yii\validators\FileValidator;
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
        $searchModel =new ProductSearchForm();

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
            return $this->renderAjax('_form', [
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
        $id=Reglobe::$app->request->post('id');
        $id='TKmL1XNx';

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

        /*$validator = new FileValidator([
            'extensions' => ['csv'],
            'maxSize' => 1024*1024
        ]);*/


        $columns= CSVColumns::ProductCSVColumn();

        if(isset($_POST['Products'])){
            $fileInstance=UploadedFile::getInstance($model, 'productCSV');
            $csvData= new ReadCsv($fileInstance);

            if($csvData->noOfColumns !== $columns)
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
        $csv->output('movies.csv', [], $columns, ',');
    }
}
