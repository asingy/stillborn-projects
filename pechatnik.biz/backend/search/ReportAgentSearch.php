<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ReportAgent;

/**
 * ReportSearch represents the model behind the search form about `backend\models\ReportAgent`.
 */
class ReportAgentSearch extends ReportAgent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_producer', 'cost_producer', 'cost_client', 'system_reward', 'agent_profit', 'status'], 'integer'],
            [['order_number', 'date', 'date_from', 'date_to'], 'safe'],
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
        $query = ReportAgent::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);



        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if ($this->load($params)) {
          // grid filtering conditions
          $query->andFilterWhere([
              'id' => $this->id,
              'date' => Yii::$app->formatter->asDate($this->date, 'php:Y-m-d'),
              'id_producer' => $this->id_producer,
              'cost_producer' => $this->cost_producer,
              'cost_client' => $this->cost_client,
              'system_reward' => $this->system_reward,
              'agent_profit' => $this->agent_profit,
              'status' => $this->status,
          ]);

          $query->andFilterWhere(['>=','date', $this->date_from==''?'':Yii::$app->formatter->asDate($this->date_from, 'php:Y-m-d')]);
          $query->andFilterWhere(['<=','date', $this->date_to==''?'':Yii::$app->formatter->asDate($this->date_to, 'php:Y-m-d')]);
          $query->andFilterWhere(['like', 'order_number', $this->order_number]);
        }


        return $dataProvider;
    }
}
