<?php

namespace auction\controllers\site;

use auction\components\Auction;
use auction\components\EventHandler;
use yii\web\User;

class LogoutController extends \yii\web\Controller
{
    /**
     * Action to Perform User Logout
     * Will go Home If User is already logout
     */
    public function actionIndex()
    {

        if(Auction::$app->user->isGuest){
            Auction::warning('User Already is Logged Out');
            return $this->goHome();
        }

        Auction::$app->user->logout();

        //Setting Logger @info
        $message = Auction::loggerMessageFormat('User logout SuccessFully' ,[
            'class' => __CLASS__ ,
            'function' => __METHOD__,
            'username' => Auction::$app->session->get('user.name'),
            'role' => Auction::$app->session->get('user.role'),
            'userId' => Auction::$app->user->id
        ]);
        Auction::info($message,Auction::LOGGER_FRONTEND_CATEGORY);

        return $this->goHome();
    }

}