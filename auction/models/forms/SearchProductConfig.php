<?php

namespace auction\models\forms;

use auction\components\Auction;
use auction\models\ProdConfName;
use auction\models\ProductConfig;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchProductConfig represents the model behind the search form about `auction\models\ProductConfig`.
 */
class SearchProductConfig extends ProductConfig
{
    public $pageSize =10;    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
        $query = ProductConfig::find();

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
            'company' => Auction::company(),
        ]);

        return $dataProvider;
    }
}
