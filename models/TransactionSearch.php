<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transaction;

/**
 * TransactionSearch represents the model behind the search form about `app\models\Transaction`.
 */
class TransactionSearch extends Transaction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'category_id', 'subcategory_id', 'keyword_id'], 'integer'],
            [['date', 'description', 'hash'], 'safe'],
            [['money_in', 'money_out', 'balance'], 'number'],
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
        $query = Transaction::find();
        
        $query->joinWith(['category', 'subcategory']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'transaction.date' => $this->date,
            'transaction.money_in' => $this->money_in,
            'transaction.money_out' => $this->money_out,
            'transaction.user_id' => Yii::$app->user->identity->id,
            'transaction.category_id' => $this->category_id,
            'transaction.subcategory_id' => $this->subcategory_id,
        ]);

        $query->andFilterWhere(['like', 'transaction.description', $this->description]);

        return $dataProvider;
    }
}
