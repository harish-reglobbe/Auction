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
    require (__DIR__.'/'.RG_ENV.'/_cache.php')
);

$config=[
    'modules' => require __DIR__.'/'.RG_ENV.'/_module.php',
    'components' => [
        'request' => [
            'cookieValidationKey' => 'CxfcG_X1KQWeDTqXCZCDqt59j8HKqvao',
        ],
        'user' => [
            'identityClass' => 'frontend\models\Users',
            'enableAutoLogin' => true,
        ],
        'response' => [
            'class' => 'yii\web\Response',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@app/runtime/logs/Request/requests.log',
                    'levels' => ['info','error','warning'],
                    'logVars' => [],
                ],
            ],
        ],
    ]
];
$config['components']=array_merge($config['components'],$components);

return $config;