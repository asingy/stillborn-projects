<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Producer;
use backend\models\AgentProducer;
use backend\models\Agent;
use yii\helpers\ArrayHelper;

/**
 * ProducerSearch represents the model behind the search form about `backend\models\Producer`.
 */
class ProducerSearch extends Producer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_contact', 'urgency', 'need_scan_docs'], 'integer'],
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
        $query = Producer::find();

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
            'id_contact' => $this->id_contact,
            'urgency' => $this->urgency,
            'need_scan_docs' => $this->need_scan_docs,
            'is_default' => $this->is_default,
        ]);

        return $dataProvider;
    }

    // public function search_by_agent($id_agent)
    // {
    //     $query = Producer::find();
    //     $ids = ArrayHelper::getColumn(AgentProducer::find()->where(['id_agent'=>$id_agent])->all(), 'id_producer');
    //     $query->where(['id'=>$ids]);
    //     $dataProvider = new ActiveDataProvider([
    //         'query' => $query,
    //     ]);
    //
    //     return $dataProvider;
    // }

    public function searchByAgent($id_agent)
    {
        $query = Producer::find();
        $query->joinWith('contact');
        $ids = ArrayHelper::getColumn(AgentProducer::find()->where(['id_agent'=>$id_agent])->all(), 'id_producer');
        $agent = Agent::findOne($id_agent);
        $query->where(['NOT IN','producer.id', $ids]);
        $query->andWhere(['contact.id_city' => $agent->contact->id_city]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}
