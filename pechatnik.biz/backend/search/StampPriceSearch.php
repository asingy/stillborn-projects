<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\StampPrice;

/**
 * StampPriceSearch represents the model behind the search form about `backend\models\StampPrice`.
 */
class StampPriceSearch extends StampPrice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_stamp', 'id_city', 'price', 'status'], 'integer'],
            [['info'], 'safe'],
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
        $query = StampPrice::find();

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
            'id' => $this->id,
            'id_stamp' => $this->id_stamp,
            'id_city' => $this->id_city,
            'price' => $this->price,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'info', $this->info]);

        return $dataProvider;
    }
}
