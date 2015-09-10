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
use yii\filters\VerbFilter;

class DealerController extends Controller
{
    //Roles Defined
    public $roles = [DatabaseHelper::DEALER];
    public $roleBaseActions = ['index'];

    public $verbs = [
        'delete' => ['post'],
    ];

    protected function rules(){
        return [
            [
                'actions' => $this->roleBaseActions,
                'allow' => true,
                'roles' => $this->roles
            ],
        ];
    }

    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                // We will override the default rule config with the new AccessRule class
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => $this->rules()
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => $this->verbs
            ],
        ];
    }

}