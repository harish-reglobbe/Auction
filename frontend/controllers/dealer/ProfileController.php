<?php

namespace frontend\controllers\dealer;


use frontend\models\Dealers;
use frontend\models\forms\DealerRegistrationForm;
use frontend\components\Reglobe;

class ProfileController extends \yii\web\Controller
{
    public function actionIndex()
    {

        $model=$this->loadModel();

        return $this->render('//dealer/profile',[
            'model' => $model
        ]);
    }

    public function actionRegistration()
    {
        $model = new DealerRegistrationForm();

        if ($model->load(Reglobe::$app->request->post())) {
            if ($user = $model->SaveDealer()) {
                if (Reglobe::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('registration', [
            'model' => $model,
        ]);
    }


    /**
     * Get Dealer Info
     */
    protected function loadModel(){

        /**
         * Load All Related Models Of Users
         * having userId is logged in dealer user Id
         */
        $query= Dealers::find()->with([
            'users',
            'dealerPreferences' => function($query){
                $query->with([
                    'category0',
                    'brand0'
                ]);
            },
            'dealerCompanies' => function($query){
                $query->with([
                    'company0',
                    'dealerCompanyPreferences' => function($query){
                    }
                ]);
            }
        ])->where([
            'user' => Reglobe::$app->user->id
        ]);

        $model=$query->one();
        return $model;
    }
}
