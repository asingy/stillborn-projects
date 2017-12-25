<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ClicheTpl;
use backend\models\ProducerClicheTpl;
use yii\helpers\ArrayHelper;

/**
 * ClicheTplSearch represents the model behind the search form about `backend\models\ClicheTpl`.
 */
class ClicheTplSearch extends ClicheTpl
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_cliche', 'sizes', 'order', 'status'], 'integer'],
            [['name', 'info'], 'safe'],
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
    public function search($params, $cliche = null)
    {
        $query = ClicheTpl::find();

        // add conditions that should always apply here
        if ($cliche !== null) {
          $query->where(['id_type' => $cliche]);
        }
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
            'id_cliche' => $this->id_cliche,
            'sizes' => $this->sizes,
            'order' => $this->order,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'info', $this->info])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }

    public function searchByProducer($id_producer, $cliche)
    {
        $query = ClicheTpl::find();

        // add conditions that should always apply here
        $choosed = ArrayHelper::getColumn(ProducerClicheTpl::find()->where(['id_producer' => $id_producer])->all(), 'id_cliche_tpl');
        $query->where(['NOT IN', 'id', $choosed]);
        $query->andWhere(['id_cliche' => $cliche]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

    public function searchByCliche($id_cliche)
    {
        $query = ClicheTpl::find();

        // add conditions that should always apply here
        $query->where(['id_cliche'=> $id_cliche]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

    // public function search_by_producer($id_producer)
    // {
    //     $query = ClicheTpl::find();
    //     $ids = ArrayHelper::getColumn(ProducerStampTpl::find()->where(['id_producer'=>$id_producer])->all(), 'id_stamp_tpl');
    //     $query->where(['id'=>$ids]);
    //     $dataProvider = new ActiveDataProvider([
    //         'query' => $query,
    //     ]);
    //
    //     return $dataProvider;
    // }
}
