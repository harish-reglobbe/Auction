<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 1/9/15
 * Time: 5:52 PM
 */

namespace auction\controllers\company;


use auction\components\Auction;
use auction\models\Companies;
use auction\models\forms\CompanyRegistration;
use auction\models\Users;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\HttpException;

class EditController extends Controller{

    public function actionIndex(){

        $model = $this->loadProfile();

        if(Auction::$app->request->isPost){
            $post = Auction::$app->request->post();
            $model->load($post);
            $model->user->load($post);

            $model->update();
        }

        return $this->render('//company/edit',[
            'model' => $model
        ]);

    }

    protected function loadProfile(){
        $model = Companies::find()->innerJoinWith([
            'user' => function($query){
                $query->where(['users.id' => Auction::user()]);
            }
        ])->where([
            'companies.id' => Auction::company(),
        ])->one();

        if($model === null){
            Auction::error('No Valid Dealer Found with userid '.Auction::$app->user->id);
            throw new HttpException(404, 'No user found');
        }

        return $model;
    }
}