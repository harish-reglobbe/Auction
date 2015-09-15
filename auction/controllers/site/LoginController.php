<?php

namespace auction\controllers\site;

use auction\components\Auction;
use auction\models\forms\LoginForm;

class LoginController extends \yii\web\Controller
{
    public $layout='login';

    public function actionIndex()
    {

        if (!Auction::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Auction::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('//site/login', [
                'model' => $model,
            ]);
        }
    }

}
