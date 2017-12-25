<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ClicheSizeStamp;

/**
 * ClicheSizeStampSearch represents the model behind the search form about `backend\models\ClicheSizeStamp`.
 */
class ClicheSizeStampSearch extends ClicheSizeStamp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          [['id_stamp', 'id_cliche', 'status'], 'integer'],
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
    public function search($params, $id_cliche)
    {
        $query = ClicheSizeStamp::find();
        if ($stamp_type !== null) {
          $query->where(['id_cliche' => $id_cliche]);
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

    public function searchByCliche($id_cliche)
    {
        $query = ClicheSizeStamp::find();
        $query->where(['id_cliche'=>$id_cliche]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}
