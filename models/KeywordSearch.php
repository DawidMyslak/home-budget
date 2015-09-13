<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Keyword;

/**
 * KeywordSearch represents the model behind the search form about `app\models\Keyword`.
 */
class KeywordSearch extends Keyword
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'category_id', 'subcategory_id'], 'integer'],
            [['name'], 'safe'],
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
        $query = Keyword::find();
        
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
            'keyword.user_id' => Yii::$app->user->identity->id,
            'keyword.category_id' => $this->category_id,
            'keyword.subcategory_id' => $this->subcategory_id,
        ]);

        $query->andFilterWhere(['like', 'keyword.name', $this->name]);

        return $dataProvider;
    }
}
