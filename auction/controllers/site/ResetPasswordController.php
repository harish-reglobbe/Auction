<?php

namespace auction\controllers\site;

use auction\components\Auction;
use auction\models\forms\PasswordReset;

class ResetPasswordController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new PasswordReset();
        if ($model->load(Auction::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Auction::$app->getSession()->setFlash('success', 'Password Has Been Resetted Check your Email for further Instructions');
            } else {
                Auction::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email/mobile provided.May be Provided Email/mobile not exist');
            }

            //refresh controller form submission
            return $this->refresh();
        }

        return $this->render('//site/reset-password',['model' => $model]);
    }

}
