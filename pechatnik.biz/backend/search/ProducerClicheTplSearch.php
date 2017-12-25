<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProducerClicheTpl;

/**
 * ProducerClicheTplSearch represents the model behind the search form about `backend\models\ProducerClicheTpl`.
 */
class ProducerClicheTplSearch extends ProducerClicheTpl
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          [['id_producer', 'id_cliche_tpl', 'status'], 'integer'],
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
        $query = ProducerClicheTpl::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        return $dataProvider;
    }

    public function searchByProducer($id_producer)
    {
        $query = ProducerClicheTpl::find();
        $query->where(['id_producer' => $id_producer]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);



        return $dataProvider;
    }
}
