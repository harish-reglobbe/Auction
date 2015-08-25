<?php

namespace auction\models\forms;

use frontend\components\Reglobe;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use auction\models\Auctions;

/**
 * SearchAuction represents the model behind the search form about `auction\models\Auctions`.
 */
class SearchAuction extends Auctions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'duration', 'company', 'status', 'priority'], 'integer'],
            [['name', 'create_date', 'start_date'], 'safe'],
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

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'start_date' => $this->start_date,
            'duration' => $this->duration,
            'amount' => $this->amount,
            'status' => $this->status,
            'priority' => $this->priority,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

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
