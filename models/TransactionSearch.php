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
    const EXPENSES = 'money_out';
    const INCOME = 'money_in';
    
    public $display;
    
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
        
        $query->joinWith(['category']);
        $query->joinWith(['subcategory']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['date' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $views = [
            self::EXPENSES,
            self::INCOME
        ];
        
        $this->display = self::EXPENSES;
        if (isset($params['display']) && in_array($params['display'], $views)) {
            $this->display = $params['display'];
        }
        
        if ($this->display === self::EXPENSES) {
            $query->where(['<>', 'transaction.money_out', null]);
            $query->where(['transaction.money_in' => null]);
        }
        else if ($this->display === self::INCOME) {
            $query->where(['<>', 'transaction.money_in', null]);
            $query->where(['transaction.money_out' => null]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'transaction.user_id' => Yii::$app->user->identity->id,
            //'transaction.date' => $this->date,
            //'transaction.category_id' => $this->category_id,
            //'transaction.subcategory_id' => $this->subcategory_id,
        ]);

        $query->andFilterWhere(['like', 'transaction.description', $this->description]);

        return $dataProvider;
    }
}
