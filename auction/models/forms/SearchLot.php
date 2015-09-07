<?php

namespace auction\models\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use auction\models\Lots;

/**
 * SearchLot represents the model behind the search form about `auction\models\Lots`.
 */
class SearchLot extends Lots
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'auction', 'lot_size', 'is_quantity'], 'integer'],
            [['name', 'condition'], 'safe'],
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
        $query = Lots::find();

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
            'auction' => $this->auction,
            'lot_size' => $this->lot_size,
            'is_quantity' => $this->is_quantity,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'condition', $this->condition]);

        return $dataProvider;
    }

    public function notAssignedAuctions(){
        $query = Lots::find()->joinWith([
            'auction0'
        ])->where([
            'auctions.status' => 0
        ]);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 2
            ]
        ]);
    }
}
