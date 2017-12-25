<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Stamp;
use backend\models\ProducerStamp;
use backend\models\ClicheStamp;
use yii\helpers\ArrayHelper;

/**
 * StampSearch represents the model behind the search form about `backend\models\Stamp`.
 */
class StampSearch extends Stamp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'sort'], 'integer'],
            [['name', 'image', 'info'], 'safe'],
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
        $query = Stamp::find();
        //$query->where(['=!','deleted', Stamp::DELETED]);
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
            'status' => $this->status,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'info', $this->info]);

        return $dataProvider;
    }

    public function searchByCliche($id_cliche)
    {
        $query = Stamp::find();
        $choosed = ArrayHelper::getColumn(ClicheStamp::find()->where(['id_cliche' => $id_cliche])->all(), 'id_stamp');
        $query->where(['NOT IN', 'id', $choosed]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

    public function searchByProducer($id_producer)
    {
        $query = Stamp::find();
        $choosed = ArrayHelper::getColumn(ProducerStamp::find()->where(['id_producer' => $id_producer])->all(), 'id_stamp');
        $query->where(['NOT IN', 'id', $choosed]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

    // public function search_by_producer($id_producer)
    // {
    //     $query = Stamp::find();
    //     $ids = ArrayHelper::getColumn(ProducerStamp::find()->where(['id_producer'=>$id_producer])->all(), 'id_stamp_case');
    //     $query->where(['id'=>$ids]);
    //     $dataProvider = new ActiveDataProvider([
    //         'query' => $query,
    //     ]);
    //
    //     return $dataProvider;
    // }

    // public function searchByStampType($id_type)
    // {
    //     $query = Stamp::find();
    //     $ids = ArrayHelper::getColumn(StampTypesCases::find()->where(['id_stamp'=>$id_type])->all(), 'id_case');
    //     $query->where(['id'=>$ids]);
    //     $dataProvider = new ActiveDataProvider([
    //         'query' => $query,
    //     ]);
    //
    //     return $dataProvider;
    // }
}
