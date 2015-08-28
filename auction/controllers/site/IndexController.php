<?php

namespace auction\controllers\site;

class IndexController extends \yii\web\Controller
{
    public function actionIndex()
    {

        phpinfo();
        exit;
//        \Yii::$app->mail->compose('dealerRegistration')
//            ->setFrom([\Yii::$app->params['supportEmail'] => 'Test Mail'])
//            ->setTo('doublehrajput@gmail.com')
//            ->setSubject('This is a test mail ' )
//            ->send();

        return $this->render('//site/index');
    }

}
