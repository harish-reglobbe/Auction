<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Auctions;

/**
 * AuctionSearch represents the model behind the search form about `frontend\models\Auctions`.
 */
class AuctionSearch extends Auctions
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
            'companies'
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
            'create_date' => $this->create_date,
            'start_date' => $this->start_date,
            'duration' => $this->duration,
            'amount' => $this->amount,
            'company' => $this->company,
            'status' => $this->status,
            'priority' => $this->priority,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
