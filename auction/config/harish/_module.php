<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 10/8/15
 * Time: 12:29 PM
 */

return [
        'gii'=>[
            'class'=>'yii\gii\Module',
            'allowedIPs'=>['127.0.0.1', '::1','192.168.1.124'],
            'generators'=>[
                'mongoDbModel' => [
                    'class' => 'yii\mongodb\gii\model\Generator'
                ]
            ],
        ],
        'admin' => [
            'class' => 'auction\modules\admin\Admin',
            'defaultRoute' => 'user'
        ],
        'debug' => [
            'class' => 'yii\debug\Module',
        ]
];