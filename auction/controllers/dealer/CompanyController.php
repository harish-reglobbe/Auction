<?php

namespace auction\controllers\dealer;

use auction\components\Auction;
use auction\components\controllers\DealerController;
use auction\components\helpers\DatabaseHelper;
use auction\models\DealerCompany;
use auction\models\DealerCompanyPreferences;
use auction\models\Companies;
use auction\models\forms\SearchCompany;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\HttpException;

/**
 * CompaniesController implements the CRUD actions for Companies model.
 */
class CompanyController extends \auction\components\controllers\Controller
{

    public $roles = [DatabaseHelper::DEALER];
    public $roleBaseActions = ['index' , 'list-companies' , 'view' , 'toggle-status', 'add-preference','delete-preference'];

    public $verbs = [
        'toggle-status' => ['post'],
        'add-preference' => ['post'],
        'delete-preference' => ['post'],
        'toggle-status' => ['get']
    ];
    /**
     * Lists all Companies models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchCompany();
        $dataProvider = $searchModel->searchDealerCompany();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /*
     * Displays a single Companies model.
     * @param integer $id
     * @return mixed
     * @throw http 404 when no company found
     */
    public function actionView($id)
    {
        $model = Companies::find()->with([
            'dealerCompanies' => function ($query) use ($id){
                $query->joinWith([
                    'dealerCompanyPreferences' => function ($query) {
                        $query->joinWith([
                            'brand0',
                            'category0'
                        ]);
                    }
                ])->where([
                    'dealer_company.company' => $id,
                    'dealer_company.dealer' => Auction::dealer()
                ]);
            }
        ])->where([
            'id' => $id
        ])->one();

        if($model === null){
            Auction::error('There is no Company with Company Id '.$id);
            throw new HttpException(404, 'No Company Found');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /** Add Company Preferences by Dealer */
    public function actionAddPreference(){
        $post = Auction::$app->request->post();

        if($post){
            $companyId= ArrayHelper::getValue($post , 'id');

            if(DealerCompanyPreferences::model()->addPreference($post)){
                if($companyId)
                    return $this->actionView($companyId);
            }else {
                throw new HttpException(400, 'Already Exist');
            }
        }
    }

    public function actionListCompanies($term){

        $array = Companies::find()->select('id,name,logo_image as image')
            ->where(['like' , 'name' , $term])
            ->asArray()->all();

        return Json::encode($array);
    }

    public function actionDeletePreference(){
        $post= Auction::$app->request->post('id');

        $post = Json::decode($post,true);

        DealerCompanyPreferences::find()->where([
            'dc_id' => $post['dc_id'],
            'category' => $post['category'],
            'brand' => $post['brand']
        ])->one()->delete();

        return $this->actionIndex();
    }

    public function actionToggleStatus($id){

        if(DealerCompany::model()->addedByDealer($id)) {
            return $this->actionView($id);
        }

        else{

            throw new HttpException(400 , 'Error in Action');
        }
    }
}
