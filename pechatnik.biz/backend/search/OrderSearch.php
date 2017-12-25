<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Order;

/**
 * OrderSearch represents the model behind the search form about `backend\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id',  'id_client', 'id_producer', 'id_stamp', 'id_cliche_tpl', 'id_delivery', 'id_payment', 'quantity', 'status', 'cost', 'id_city', 'id_user'], 'integer'],
            [['date', 'date_close', 'delivery_address', 'number', 'info'], 'safe'],
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
    public function search($params, $status = null)
    {
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC,
                ],
            ],
        ]);

        if ($status !== null) {
          $query->where(['status' => $status]);
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->load($params)) {

          // grid filtering conditions
          $query->andFilterWhere([
              'id' => $this->id,
              'id_client' => $this->id_client,
              'id_producer' => $this->id_producer,
              'id_stamp' => $this->id_stamp,
              'id_cliche_tpl' => $this->id_cliche_tpl,
              'id_delivery' => $this->id_delivery,
              'id_payment' => $this->id_payment,
              'quantity' => $this->quantity,
              'status' => $this->status,
              'cost' => $this->cost,
              'id_city' => $this->id_city,
              'id_user' => $this->id_user,
              // 'date' => $this->date,
              'date_close' => $this->date_close,
          ]);
              if ($this->date !== '') {
                $query->andFilterWhere(['between','date', Yii::$app->formatter->asDate($this->date, 'php:Y-m-d'). ' 00:00', Yii::$app->formatter->asDate($this->date, 'php:Y-m-d'). ' 23:59']);
              }

              $query->andFilterWhere(['like', 'info', $this->info])
              ->andFilterWhere(['like', 'number', $this->number])
              ->andFilterWhere(['like', 'delivery_address', $this->delivery_address]);
        }

        return $dataProvider;
    }
}
