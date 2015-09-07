<?php

namespace auction\modules\admin\controllers;

use auction\components\Auction;
use auction\models\Auctions;
use auction\models\Brands;
use auction\models\Categories;
use auction\models\Companies;
use auction\models\Dealers;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index',[
            'dataProvider' => $this->dataTables()
        ]);
    }

    protected function dataTables(){

        $allModels =  (new Query())->select(
            '('.(new Query())->select('count(*)')->from(Auctions::tableName())->createCommand()->rawSql.') as auctions,'.
            '('.(new Query())->select('count(*)')->from(Dealers::tableName())->createCommand()->rawSql.') as dealers,'.
            '('.(new Query())->select('count(*)')->from(Companies::tableName())->createCommand()->rawSql.') as companies,'.
            '('.(new Query())->select('count(*)')->from(Brands::tableName())->createCommand()->rawSql.') as brands,'.
            '('.(new Query())->select('count(*)')->from(Categories::tableName())->createCommand()->rawSql.') as categories'
        )->one();

        $_message = Auction::loggerMessageFormat('Admin Dashboard Created With :: ',$allModels);
        Auction::info($_message);

        return new ArrayDataProvider([
            'allModels' => $allModels,
            'pagination' => false
        ]);

    }
}
