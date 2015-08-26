<?php

namespace auction\modules\admin;

use auction\components\Auction;
use auction\components\helpers\DatabaseHelper;
use yii\web\HttpException;

class Admin extends \yii\base\Module
{
    public $controllerNamespace = 'auction\modules\admin\controllers';

    public function init()
    {
        parent::init();

    }

    public function beforeAction($action){

        $role=Auction::$app->session->get('user.role');

        if(Auction::$app->user->isGuest){
            Auction::$app->user->loginRequired();
        }

        if($role === DatabaseHelper::ADMIN)
            return true;

        else
            throw new HttpException('403','ForBidden');

    }
}
