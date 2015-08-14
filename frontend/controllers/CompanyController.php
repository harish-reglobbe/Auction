<?php

namespace frontend\controllers;

use frontend\components\Reglobe;
use frontend\models\Companies;
use frontend\components\AccessRule;
use frontend\models\forms\CompanyRegistrationForm;
use frontend\models\Users;
use yii\filters\AccessControl;

class CompanyController extends \yii\web\Controller
{

    //Behaviour to Apply Access Filtering
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                // We will override the default rule config with the new AccessRule class
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['index', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [
                            Users::ROLE_COMPANY_ADMIN
                        ],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => [
                        ],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [
                        ],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRegistration()
    {
        $model = new CompanyRegistrationForm();

        if ($model->load(Reglobe::$app->request->post())) {
            if ($user = $model->SaveCompany()) {
                if (Reglobe::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('registration', [
            'model' => $model,
        ]);
    }

}
