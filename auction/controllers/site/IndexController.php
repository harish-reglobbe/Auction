<?php

namespace auction\controllers\site;

use auction\components\Auction;
use auction\components\helpers\DatabaseHelper;

class IndexController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if(Auction::$app->user->isGuest){
            $this->redirect(Auction::$app->urlManager->createAbsoluteUrl('site/login'));
        }

        switch (Auction::$app->session->get('user.role')){
            case DatabaseHelper::ADMIN :
                $this->redirect(Auction::$app->urlManager->createAbsoluteUrl('admin'));
                break;

            case DatabaseHelper::DEALER :
                $this->redirect(Auction::$app->urlManager->createAbsoluteUrl('dealer/profile'));
                break;

            case DatabaseHelper::COMPANY_USER :
                $this->redirect(Auction::$app->urlManager->createAbsoluteUrl('company/profile'));
                break;

            case DatabaseHelper::COMPANY_ADMIN :
                $this->redirect(Auction::$app->urlManager->createAbsoluteUrl('company/info'));
                break;

            default :
                $this->redirect(Auction::$app->urlManager->createAbsoluteUrl('site/login'));
        }
    }

}
