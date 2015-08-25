<?php

namespace auction\controllers\site;

class ResetPasswordController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('//site/reset-password');
    }

}
