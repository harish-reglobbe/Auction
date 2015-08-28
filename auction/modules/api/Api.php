<?php

namespace auction\modules\api;

use auction\components\Auction;

class Api extends \yii\base\Module
{
    public $controllerNamespace = 'auction\modules\api\controllers';

    public function init()
    {

        Auction::$app->setComponents([
            'user' => [
                'class' => 'yii\web\User',
                'identityClass' => 'auction\modules\api\components\RestIdentity',
                'enableAutoLogin' => false,
                'enableSession' => false,
            ],
            'japi'=>[
                'class' => 'auction\components\JAPI',
                'maxRedirects' => 0,
                'timeout' => 30,//IN SECONDS
                'keepalive' => true,
                'debug' => false,
                "authKey"=>"SN-5133643633079",
            ],
        ]);

        Auction::info('Auction API Module Started:::::::'.__METHOD__,'request');

        parent::init();

    }

}
