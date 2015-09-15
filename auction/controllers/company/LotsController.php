<?php

namespace auction\controllers\company;

use auction\components\Auction;
use auction\models\LotPreference;
use Yii;
use auction\models\Lots;
use auction\models\forms\SearchLot;
use yii\web\NotFoundHttpException;
use auction\components\helpers\DatabaseHelper;

/**
 * LotsController implements the CRUD actions for Lots model.
 */
class LotsController extends \auction\components\controllers\Controller
{
    public $roles = [DatabaseHelper::COMPANY_ADMIN , DatabaseHelper::COMPANY_USER];
    public $roleBaseActions = ['index' , 'view' ,'create' , 'update'];

    public $verbs = [
        'view' => ['get'],
        'index' => ['get'],
        'update' => ['post'],
    ];


    /**
     * Displays a single Lots model.
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
     * Creates a new Lots model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lots();

        $model->auction = Auction::$app->request->get('auction');
        $model->lotPreferences = new LotPreference();

        if (Lots::model()->saveLot(Yii::$app->request->post())) {
            return 'Success';
        } else {
            return $this->renderPartial('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Lots model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $id = Auction::$app->request->post('id');

        if($id){
            $model = Lots::find()->joinWith(['lotPreferences'])->where('lots.id=:id',[':id' => $id])->one();

            if (isset($_POST['Lots'])) {
                $model->load(Yii::$app->request->post());
                $model->lotPreferences->load(Yii::$app->request->post());

                if($model->update())
                    return 'Success';
            } else {
                return $this->renderPartial('_form', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Deletes an existing Lots model.
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
     * Finds the Lots model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lots the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lots::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAuctionNotAssigned(){


        $searchModel = new SearchLot();
        $dataProvider = $searchModel->notAssignedAuctions(Yii::$app->request->queryParams);

        return $this->renderPartial('index', [
            'model' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
}
