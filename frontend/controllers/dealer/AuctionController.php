<?php

namespace frontend\controllers\dealer;

use frontend\components\Reglobe;
use frontend\models\forms\DealerAuctionSearchForm;

class AuctionController extends \yii\web\Controller
{


    /**
     * Dealers's Auction Where Dealer Can See/Previous Applied Auction
     * Can Perform Action with role == DEALER_ROLE_NAME
     * Lists all Auctions models.
     * @return auction view of dealers
     *
     *
     */

    public function actionIndex()
    {
        $searchModel = new DealerAuctionSearchForm();
        $dataProvider = $searchModel->search(Reglobe::$app->request->queryParams);

        return $this->render('//dealer/auction', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
