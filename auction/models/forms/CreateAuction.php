<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 24/8/15
 * Time: 3:30 PM
 */

namespace auction\models\forms;


use auction\components\Auction;
use auction\models\AuctionPreference;
use auction\models\AuctionsCriteria;
use auction\models\BidsTerm;
use frontend\models\Auctions;
use yii\base\Exception;
use yii\base\Model;

class CreateAuction extends Model{

    public $name;
    public $duration;
    public $amount;
    public $start_date;
    public $company;
    public $status;
    public $priority;
    public $security;
    public $is_percent;
    public $max_bid;
    public $cooling_prd;
    public $last_min_extd;
    public $max_extd;
    public $category;
    public $brand;


    public function rules(){
        return [
            [['name','amount','duration','start_date','company','status','priority','security','is_percent','max_bid','cooling_prd','last_min_extd','max_extd','category','brand'],'safe']
        ];
    }

    public function attributeLabels(){
        return [
            'name' =>'Auction Name',
            'duration' => 'Duration',
            'amount' => 'Amount',
            'company' => 'Company',
            'status' => 'Status',
            'priority' => 'Priority',
            'security' => 'Security',
            'is_percent' => 'Is Percent',
            'max_bid' => 'Maximum Bid',
            'cooling_prd' => 'Cooling Period',
            'last_min_extd' => 'Last Minute Extension',
            'max_extd' => 'Maximum Extension',
            'category' => 'Category',
            'brand' => 'Brand'
        ];
    }

    public function init(){
        $this->company = Auction::$app->session->get('user.company',0);
    }

    public function save(){

        $transaction=Auction::$app->db->beginTransaction();
        try{

            $auction=$this->loadAuction();

            if($auction === null){
                return null;
            }

            $auctionCriteria=$this->loadAuctionCriteria($auction);
            $auctionBids=$this->loadAuctionBids($auction);
            $auctionPreference=$this->loadAuctionPreferences($auction);

            if(!$auctionCriteria || !$auctionBids || !$auctionPreference){
                return null;
            }

            $transaction->commit();
            return $auction;

        }catch(Exception $ex){
            $transaction->rollBack();
            return null;
        }

    }

    /**
     * @return mixed|null primary key of created Auction Model
     */
    private function loadAuction(){
        $model= new Auctions();

        return $this->saveModel($model);
    }

    /**
     * Save Auction Criteria
     * @return mixed/null primary key of created Auction Criteris Model
     */
    private function loadAuctionCriteria($auction){
        $model= new AuctionsCriteria();

        $model->auction=$auction;
        return $this->saveModel($model);
    }

    /**
     * Save Auction Bid
     * @return Mixed|null Primary Key of Auction Bid
     */
    private function loadAuctionBids($auction){
        $model= new BidsTerm();

        $model->auction=$auction;
        return $this->saveModel($model);
    }

    private function loadAuctionPreferences($auction){
        $model= new AuctionPreference();

        $model->auction=$auction;
        return $this->saveModel($model);
    }

    /**
     * @param $model
     * @return null|Mixed saved model primary key by setting it's attributes Validation to false
     */
    private function saveModel($model){
        $model->setAttributes($this->getAttributes(),false);

        if($model->save(false)){
            return $model->primaryKey;
        }
        else {
            return null;
        }
    }
}