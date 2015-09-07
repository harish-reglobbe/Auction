<?php
/**
 * Created by PhpStorm.
 * Date: 7/8/15
 * Time: 2:01 PM
 *
 * Provide Application Configuration For Yii Application
 */
// <editor-fold desc="My Helder Dump Function">
function dump($model,$die=true){
yii\helpers\VarDumper::dump($model,10,true);

    if($die)
        exit;
}
// </editor-fold>

$components=array_merge(
    require (__DIR__.'/'.RG_ENV.'/_db.php'),
    require (__DIR__.'/'.RG_ENV.'/_cache.php'),
    require (__DIR__.'/'.RG_ENV.'/_mail.php')
);

$config=[
    'modules' => require __DIR__.'/'.RG_ENV.'/_module.php',
    'components' => [
        'request' => [
            'class' => 'auction\components\AuctionRequest',
            'cookieValidationKey' => 'CxfcG_X1KQWeDTqXCZCDqt59j8HKqvao',
        ],
        'user' => [
            'identityClass' => 'auction\models\Users',
            'enableAutoLogin' => true,
        ],
        'response' => [
            'class' => 'yii\web\Response',
        ],
        'log' => [
            'traceLevel' => 0,
            'targets' => [
                [
                    'class' => 'auction\components\log\FileTarget',
                    'levels' => ['error', 'warning','info','trace'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'formatter' => [ 'class' => 'yii\i18n\Formatter', 'datetimeFormat' => 'Y-MM-dd hh:i:s', 'timeFormat' => 'H:i:s', 'nullDisplay' => '']
    ]
];
$config['components']=array_merge($config['components'],$components);

return $config;