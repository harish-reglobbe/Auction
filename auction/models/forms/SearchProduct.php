<?php

namespace auction\models\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use auction\models\Products;

/**
 * ProductSearchForm represents the model behind the search form about `frontend\models\Products`.
 */
class SearchProduct extends Products
{
    /**
     * @inheritdoc
     */
    public $pageSize =10;

    public function rules()
    {
        return [
            [['_id', 'pageSize',], 'safe'],
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
        $query = Products::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'lot', $this->lot_id])
            ->andFilterWhere(['like', 'prize', $this->prize]);

        return $dataProvider;
    }
}
