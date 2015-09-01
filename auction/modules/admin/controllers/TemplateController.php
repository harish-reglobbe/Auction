<?php

namespace auction\modules\admin\controllers;

use Yii;
use auction\models\MessageTemplate;
use auction\models\forms\SearchTemplate;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TemplateController implements the CRUD actions for MessageTemplate model.
 */
class TemplateController extends CategoryController
{

    /**
     * Lists all MessageTemplate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchTemplate();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new MessageTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MessageTemplate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'Success';
        } else {
            return $this->renderPartial('_form', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Finds the MessageTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MessageTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MessageTemplate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
