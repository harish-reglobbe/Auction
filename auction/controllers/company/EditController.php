<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 1/9/15
 * Time: 5:52 PM
 */

namespace auction\controllers\company;


use auction\components\Auction;
use auction\models\forms\CompanyRegistration;
use auction\models\Users;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\HttpException;

class EditController extends Controller{

    public function actionIndex(){

        $model= new CompanyRegistration();

        if(Auction::$app->request->isPost){

            $model->load(Auction::$app->request->post());
            $model->SaveCompany();

        }
        else {

            $modelAttributes = ArrayHelper::merge($this->loadModel()->getAttributes(), $this->loadModel()->company->attributes);
            $model->setAttributes($modelAttributes);

        }

        return $this->render('//company/edit',['model' => $model]);

    }

    protected function loadModel(){

        $model = Users::find()->joinWith([
            'company'
        ])->where([
            'users.id' => Auction::$app->user->id
        ])->one();

        if($model === null){
            throw new HttpException(400 , 'Not A Valid Company Admin');
        }

        return $model;
    }
}