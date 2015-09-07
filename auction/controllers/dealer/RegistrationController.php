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

        if ($model->load(Auction::$app->request->post()) && $model->save()) {
            Auction::$app->session->setFlash('success', 'Thank you For Registration Check Your Email to activate Your Account');
            return $this->refresh();
        }

        return $this->render('//dealer/registration', [
            'model' => $model,
        ]);
    }

}
