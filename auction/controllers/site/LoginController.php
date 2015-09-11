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
            Auction::infoLog('User Successfully Logged in With Deatils' , $GLOBALS['_SESSION']);
            return $this->goBack();
        } else {
            Auction::infoLog('User Authentication Failed Due To Following Errors',$model->getErrors());
            return $this->render('//site/login', [
                'model' => $model,
            ]);
        }
    }

}
