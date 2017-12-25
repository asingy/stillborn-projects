<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProducerStamp;

/**
 * ProducerStampSearch represents the model behind the search form about `backend\models\ProducerStamp`.
 */
class ProducerStampSearch extends ProducerStamp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          [['id_producer', 'id_stamp', 'status', 'price'], 'integer'],
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
        $query = ProducerStamp::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        return $dataProvider;
    }

    public function searchByProducer($id_producer)
    {
        $query = ProducerStamp::find();
        $query->where(['id_producer' => $id_producer]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);



        return $dataProvider;
    }
}
