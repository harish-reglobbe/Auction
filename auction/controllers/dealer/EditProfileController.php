<?php

namespace auction\controllers\dealer;

use auction\components\Auction;
use auction\components\controllers\DealerController;
use auction\components\helpers\AccessRule;
use auction\models\DealerCompanyPreferences;
use auction\models\DealerPreference;
use auction\models\Dealers;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\HttpException;

class EditProfileController extends Controller
{

    public function actionIndex()
    {
        $model = $this->loadProfile();

        if(Auction::$app->request->isPost){
            $post = Auction::$app->request->post();
            $model->load($post);
            $model->user0->load($post);

            $model->update();
        }

        return $this->render('index',[
            'model' => $model
        ]);
    }

    protected function loadProfile(){
        $model = Dealers::find()->joinWith([
            'user0',
            'dealerPreferences' => function($query){
                $query->with([
                    'category0',
                    'brand0'
                ]);
            }
        ])->where([
            'dealers.id' => Auction::$app->session->get('user.dealer', 0)
        ])->one();

        if($model === null){
            Auction::error('No Valid Dealer Found with userid '.Auction::$app->user->id);
            throw new HttpException(404, 'No user found');
        }

        return $model;
    }


    public function actionAddPreference(){
        $post = Auction::$app->request->post();

        if($post){
            $model = new DealerPreference();
            $model->brand = $post['brand'];
            $model->category = $post['category'];
            $model->dealer = Auction::dealer();

            if($model->save()){
                return $this->actionIndex();
            }else {
                throw new HttpException(400, 'Already Exist');
            }
        }
    }

    public function actionDeletePreference(){
        $post= Auction::$app->request->post('id');

        $post = Json::decode($post,true);

        if(DealerPreference::model()->deletePreference($post)) {
            return $this->actionIndex();
        }
    }
}
