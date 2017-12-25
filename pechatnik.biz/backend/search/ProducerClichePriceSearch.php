<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProducerClichePrice;

/**
 * ProducerStampCasesSearch represents the model behind the search form about `backend\models\ProducerStampCases`.
 */
class ProducerClichePriceSearch extends ProducerClichePrice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          [['id_producer', 'id_cliche', 'id_cliche_size', 'status'], 'integer'],
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
        $query = ProducerClichePrice::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        return $dataProvider;
    }

    public function searchByProducer($id_producer)
    {
        $query = ProducerClichePrice::find();
        $query->where(['id_producer' => $id_producer]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);



        return $dataProvider;
    }
}
