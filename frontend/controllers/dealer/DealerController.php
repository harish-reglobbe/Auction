<?php

namespace frontend\controllers;


use frontend\models\forms\DealerRegistrationForm;
use frontend\components\Reglobe;

class DealerController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRegistration()
    {
        $model = new DealerRegistrationForm();

        if ($model->load(Reglobe::$app->request->post())) {
            if ($user = $model->SaveDealer()) {
                if (Reglobe::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('registration', [
            'model' => $model,
        ]);
    }

}
