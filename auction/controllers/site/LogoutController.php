<?php

namespace auction\controllers\site;

use auction\components\Auction;

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
        Auction::infoLog('User logout SuccessFully' ,[
            'username' => Auction::username(),
            'role' => Auction::userRole(),
            'userId' => Auction::user()
        ]);

        return $this->goHome();
    }

}