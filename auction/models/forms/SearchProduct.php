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
    public $category;
    public $brand;
    public $name;

    public function rules()
    {
        return [
            [['pageSize','category','brand','name'], 'safe'],
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
        $query = Products::find()->with(
            'category0',
            'brand0'
        );

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        //dump($this);

        $dataProvider->pagination->pageSize=$this->pageSize;

        $query->andFilterWhere([
            'cat_id' => ($this->category) ? intval($this->category) : '',
            'brand_id' => ($this->brand) ? intval($this->brand) : '',
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function searchLots($params){

        $dataProvider= $this->search($params);

        $dataProvider->query->andWhere([
            'lot_id' => null
        ]);

        return $dataProvider;

    }
}
