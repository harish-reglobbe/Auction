<?php

namespace auction\models\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use auction\models\Categories;

/**
 * SearchCategory represents the model behind the search form about `auction\models\Categories`.
 */
class SearchCategory extends Categories
{
    /**
     * @inheritdoc
     */
    public $pageSize=10;

    public function rules()
    {
        return [
            [['pageSize', 'is_active'], 'integer'],
            [['name', 'description', 'create_date', 'update_date'], 'safe'],
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
        $query = Categories::find();

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
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'description', $this->description])
                 ->andFilterWhere(['like', 'create_date', $this->create_date]);

        return $dataProvider;
    }
}
