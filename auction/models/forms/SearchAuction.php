<?php

namespace auction\models\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use auction\models\Auctions;

/**
 * SearchAuction represents the model behind the search form about `auction\models\Auctions`.
 */
class SearchAuction extends Auctions
{

    public $pageSize=10;
    public $companyName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'duration', 'status', 'priority','pageSize'], 'integer'],
            [['name', 'create_date', 'start_date','companyName'], 'safe'],
            [['amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Auctions::find()->joinWith([
            'company0',
            'auctionsCriterias',
            'bidsTerms'
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $dataProvider->pagination->pageSize=$this->pageSize;

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'duration' => $this->duration,
            'auctions.amount' => $this->amount,
            'auctions.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'auctions.name', $this->name])
            ->andFilterWhere(['like', 'companies.name', $this->companyName])
            ->andFilterWhere(['like', 'auctions.create_date', $this->create_date]);

        return $dataProvider;
    }

    /**
     * @param $params
     *
     * Search Auction of company using session value of user.company
     *
     * @return ActiveDataProvider
     */
    public function companyAuction($params){
        $dataProvider= $this->search($params);

        $dataProvider->query->andWhere([
            'companies.id' => 2
        ]);

        return $dataProvider;
    }

}
