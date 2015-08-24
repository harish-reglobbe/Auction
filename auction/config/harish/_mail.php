<?php
/**
 * Created by PhpStorm.
 * User: Double H
 * Date: 22-08-2015
 * Time: 02:59 PM
 */

return [
    'mail' => [
        'class' => 'yii\swiftmailer\Mailer',
        'viewPath' => '@auction/mail',
        'useFileTransport' => false,//set this property to false to send mails to real email addresses
        //comment the following array to send mail using php's mail function
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.gmail.com',
            'username' => 'harish.r@reglobe.in',
            'password' => 'hari.raj',
            'port' => '587',
            'encryption' => 'tls',
        ],
    ],
];