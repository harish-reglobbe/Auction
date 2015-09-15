<?php

namespace auction\controllers\site;

use auction\components\Auction;
use auction\components\helpers\DatabaseHelper;
use auction\models\Users;

class ActivateAccountController extends \yii\web\Controller
{

    public $layout = 'login';

    public function actionIndex($email, $token)
    {
        $this->findModel($email , $token);
        return $this->render('//site/activate-account');
    }

    /**
     * @param $email user email
     * @param $token user - tokrn in url
     *
     * Find And activate user Account
     */
    protected function findModel($email , $token){
        $_model = Users::find()->where('email = :email and password = :pass',[
            'email' => $email,
            ':pass' => $token
        ])->one();

        if(!$_model){
            $this->setUserFlash('Not A valid Link o link Expire');
        }else{
            if($_model->is_active == DatabaseHelper::ACTIVE){
                $this->setUserFlash('User is already Activated');
            }else{
                $_model->is_active = DatabaseHelper::ACTIVE;
                $_model->save();
                $this->setUserFlash('Account Activated');
            }

        }
    }

    private function setUserFlash($message){
        $session = Auction::$app->session;

        $session->setFlash('activate-status' , $message);
        Auction::errorLog('User Activation', $session->getAllFlashes());
    }

}
