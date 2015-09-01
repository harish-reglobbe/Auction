<?php

namespace auction\controllers\dealer;

use auction\components\Auction;
use auction\models\forms\DealerRegistration;

class RegistrationController extends \yii\web\Controller
{
    public $layout = 'login';

    public function actionIndex()
    {
        if(!Auction::$app->user->isGuest){
            $this->redirect($this->goHome());
        }

        $model = new DealerRegistration();

        if ($model->load(Auction::$app->request->post())) {
            if ($user = $model->SaveDealer()) {
                Auction::$app->session->setFlash('success', 'Thank you ');
            }

            return $this->refresh();
        }

        return $this->render('//dealer/registration', [
            'model' => $model,
        ]);
    }

}
