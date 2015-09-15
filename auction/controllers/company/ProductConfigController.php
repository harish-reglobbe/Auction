<?php

namespace auction\controllers\company;

use auction\components\controllers\Controller;
use auction\components\helpers\DatabaseHelper;
use auction\models\ProdConfName;
use auction\models\ProdConfParam;
use auction\modules\admin\components\ParseCSV;
use Yii;
use auction\models\ProductConfig;
use auction\models\forms\SearchProductConfig;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductConfigController implements the CRUD actions for ProductConfig model.
 */
class ProductConfigController extends Controller
{
    public $roles = [DatabaseHelper::COMPANY_ADMIN, DatabaseHelper::COMPANY_USER];
    public $roleBaseActions = ['index' , 'view' , 'create' ,'update', 'delete' ,'paramAdd' , 'deleteParam'];

    /**
     * Lists all ProductConfig models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new SearchProductConfig();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductConfig model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductConfig model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductConfig();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return true;
        } else {
            return $this->renderPartial('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductConfig model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductConfig model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductConfig model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductConfig the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = ProdConfName::find()->joinWith([
            'proConf',
            'prodConfParams'
        ])->where([
            'prod_conf_name.id' => $id
        ])->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Create new model.
     */
    public function actionParamAdd()
    {
        if(Yii::$app->request->isPjax){
            $model = new ProdConfParam();
            $post = Yii::$app->request->post();


            $model->p_conf_n_id = $post['ProdConfName']['id'];
            $model->name= $post['param-name'];

            $model->save();

        }

        return $this->render('update', [
            'model' => $this->findModel($model->p_conf_n_id),
        ]);
    }

    /**
     * Delete model.
     * @param int $id
     */
    public function actionDeleteParam()
    {
        $id= Yii::$app->request->post('id');

        ProdConfParam::findOne($id)->delete();
    }

    public function actionDownloadCsv($id){
        $model = $this->findModel($id);

        $param = [];

        if(!$model->prodConfParams){
            throw new HttpException(404, 'Please Add Param Condition');
        }

        foreach($model->prodConfParams as $conf){
            $param[]=$conf->name;
        }

        $category = [$model->proConf->cat->name];
        $defaultColumns= ['Name','Image','Prize','Condition','Brand'];

        $requiredColumns = ArrayHelper::merge($defaultColumns,$category);
        $requiredColumns = ArrayHelper::merge($requiredColumns,$param);

        $csv = new ParseCSV();

        $csv->output('Products.csv', [], $requiredColumns, ',');
    }
}
