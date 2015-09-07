<?php

namespace auction\controllers\company;

use auction\components\Auction;
use auction\models\forms\SearchProduct;
use auction\models\Products;

class LotProductController extends \yii\web\Controller
{
    public function actionIndex()
    {

        $searchModel =new SearchProduct();

        $dataProvider = $searchModel->searchLots(Auction::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate(){
        dump(Auction::$app->request->post());
    }

}
