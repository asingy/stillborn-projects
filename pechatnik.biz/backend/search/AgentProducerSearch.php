<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AgentProducer;

/**
 * AgentProducerSearch represents the model behind the search form about `backend\models\AgentProducer`.
 */
class AgentProducerSearch extends AgentProducer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          [['id_producer', 'id_agent', 'status'], 'integer'],
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
        $query = AgentProducer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

    public function searchByAgent($id_agent)
    {
        $query = AgentProducer::find();
        $query->where(['id_agent' => $id_agent]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}
