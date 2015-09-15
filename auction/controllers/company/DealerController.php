<?php

namespace auction\controllers\company;

use auction\components\Auction;
use auction\components\helpers\DatabaseHelper;
use auction\models\DealerCompany;
use Yii;
use auction\models\Dealers;
use auction\models\forms\SearchCompany;
use yii\web\NotFoundHttpException;

/**
 * DealerController implements the CRUD actions for Dealers model.
 */
class DealerController extends \auction\components\controllers\Controller
{
    public $roles = [DatabaseHelper::COMPANY_ADMIN , DatabaseHelper::COMPANY_USER];
    public $roleBaseActions = ['index' , 'view' ,'activate' , 'deactivate'];

    public $verbs = [
        'view' => ['get'],
        'index' => ['get'],
        'deactivate' => ['post'],
        'activate' => ['post']
    ];

    /**
     * Lists all Dealers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchCompany();
        $dataProvider = $searchModel->searchCompanyDealer();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dealers model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $_model = Dealers::find()
                    ->with(['user0'])
                    ->where('id=:id',[':id' => $id])
                    ->one();

        if($_model === null){
            Auction::infoLog('No Dealer Found' , ['id' => $id]);
            throw new NotFoundHttpException('No Dealer Found');
        }
        return $this->render('view', [
            'model' => $_model
        ]);
    }

    /**
     * Deletes an existing Dealers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeactivate()
    {
        $id= Auction::$app->request->post('id',0);

        if($id){
            $model = $this->findModel($id);
            $model->is_active = DatabaseHelper::IN_ACTIVE;

            if(!$model->save()){
                return false;
            }
        }
    }

    public function actionActivate()
    {
        $id= Auction::$app->request->post('id',0);

        if($id){
            $model = $this->findModel($id);
            $model->is_active = DatabaseHelper::ACTIVE;
            $model->touch('aprv_date');
          //  $model->aprv_by = Auction::username();

            if(!$model->save()){
                return false;
            }
        }
    }

    /**
     * Finds the Dealers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dealers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DealerCompany::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
