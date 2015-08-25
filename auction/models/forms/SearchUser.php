<?php

namespace auction\models\forms;

use auction\components\Auction;
use auction\components\helpers\DatabaseHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use auction\models\Users;

/**
 * SearchUser represents the model behind the search form about `auction\models\Users`.
 */
class SearchUser extends Users
{
    /**
     * @inheritdoc
     */
    /**
     * @property Deafult to 10
     */
    public $pageSize=10;

    public function rules()
    {
        return [
            [['name', 'email', 'mobile', 'user_role', 'created_at','pageSize','is_active'], 'safe'],
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
        $query = Users::find()->joinWith([
            'company'
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize
            ]
        ]);

        $this->load($params);

        $dataProvider->pagination->pageSize=$this->pageSize;

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->where(['!=', 'users.user_role', DatabaseHelper::ADMIN]);

        $query->andFilterWhere([
            'users.is_active' => $this->is_active,
            'users.user_role' => $this->user_role,
        ]);

        $query->andFilterWhere(['like', 'users.name', $this->name])
            ->andFilterWhere(['like', 'users.email', $this->email])
            ->andFilterWhere(['like', 'users.mobile', $this->mobile])
            ->andFilterWhere(['like', 'users.created_at', $this->created_at]);

        return $dataProvider;
    }

    /**
     * @param $params
     *
     * Search Users of company using session value of user.company
     *
     * @return ActiveDataProvider
     */
    public function companyUser($params){
        $dataProvider= $this->search($params);

        //Getting Session Value of user.company Saved During Login Time is user is company/company_admin
        $dataProvider->query->andWhere('companies.id=:cid and users.id!=:uid',[
            ':uid' => Auction::$app->user->id,
            ':cid' => Auction::$app->session->get('user.company',0)
        ]);

        return $dataProvider;
    }
}
