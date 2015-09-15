<?php

namespace auction\controllers\company;
use auction\components\Auction;
use auction\models\forms\CompanyRegistration;

use yii\web\Controller;

class RegistrationController extends Controller
{
    public $layout='login';

    public function actionIndex()
    {
        if(!Auction::$app->user->isGuest){
            $this->redirect($this->goHome());
        }

        $model = new CompanyRegistration();

        if ($model->load(Auction::$app->request->post()) && $model->save()) {
                Auction::$app->session->setFlash('success', 'Thank you ');

            return $this->refresh();
        }

        return $this->render('//company/registration', [
            'model' => $model,
        ]);
    }

}
