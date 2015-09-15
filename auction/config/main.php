<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-auction',
    'basePath' => dirname(__DIR__),
    'name' => 'Auction',
    'controllerNamespace' => 'auction\controllers',
    'defaultRoute' => 'site/index',
    'bootstrap' => ['log' , 'debug'],
    'modules' => [],
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
