<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 10/8/15
 * Time: 12:01 PM
 */
define('TABLE_PREFIX', '');

return [
    'db' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=rg_auction',
        'username' => 'root',
        'password' => 'hari',
        'charset' => 'utf8',
        'tablePrefix' => TABLE_PREFIX
    ],
    'mongodb' => [
        'class' => '\yii\mongodb\Connection',
        'dsn' => 'mongodb://localhost:27017/auction',
    ],
];