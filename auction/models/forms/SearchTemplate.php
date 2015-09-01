<?php

namespace auction\models\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use auction\models\MessageTemplate;

/**
 * SearchTemplate represents the model behind the search form about `auction\models\MessageTemplate`.
 */
class SearchTemplate extends MessageTemplate
{
    /**
     * @inheritdoc
     */
    public $pageSize=10;

    public function rules()
    {
        return [
            [['id', 'type', 'is_active','pageSize'], 'integer'],
            [['name', 'text', 'created_at', 'updated_at'], 'safe'],
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
        $query = MessageTemplate::find();

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
            'id' => $this->id,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
