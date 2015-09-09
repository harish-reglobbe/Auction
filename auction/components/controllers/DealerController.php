<?php
/**
 * Created by PhpStorm.
 * User: Double H
 * Date: 06-09-2015
 * Time: 09:49 AM
 */

namespace auction\components\controllers;


use auction\components\helpers\AccessRule;
use auction\components\helpers\DatabaseHelper;
use yii\filters\AccessControl;
use yii\web\Controller;

class DealerController extends Controller
{
    public $roles = [DatabaseHelper::DEALER];


    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                // We will override the default rule config with the new AccessRule class
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => $this->roles
                    ],
                ],
            ],
        ];
    }

}