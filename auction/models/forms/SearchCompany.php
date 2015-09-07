<?php

namespace auction\models\forms;

use auction\components\Auction;
use auction\components\helpers\DatabaseHelper;
use auction\models\DealerCompany;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use auction\models\Companies;

/**
 * SearchCompany represents the model behind the search form about `auction\models\Companies`.
 */
class SearchCompany extends Companies
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_active'], 'integer'],
            [['name', 'domain', 'contact', 'create_date', 'update_date', 'description', 'address', 'logo_image'], 'safe'],
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
        $query = Companies::find();

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
            'update_date' => $this->update_date,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'domain', $this->domain])
            ->andFilterWhere(['like', 'contact', $this->contact])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'logo_image', $this->logo_image]);

        return $dataProvider;
    }

    public function searchDealerCompany(){
        $query = DealerCompany::find()->joinWith([
            'company0',
        ])->where([
            'dealer_company.dealer' => Auction::$app->session->get('user.dealer'),
         //   'dealer_company.is_active' => DatabaseHelper::ACTIVE
        ]);

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    public function searchCompanyDealer(){
        $query = DealerCompany::find()->joinWith([
            'dealer0',
        ])->where([
            'dealer_company.company' => Auction::$app->session->get('user.company'),
          //  'dealer_company.is_active' => DatabaseHelper::ACTIVE
        ]);

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}
