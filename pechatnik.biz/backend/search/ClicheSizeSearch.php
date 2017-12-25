<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ClicheSize;
use yii\helpers\ArrayHelper;

/**
 * ClicheSizeSearch represents the model behind the search form about `backend\models\ClicheSize`.
 */
class ClicheSizeSearch extends ClicheSize
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cliche'], 'integer'],
            [['size'], 'safe'],
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
        $query = ClicheSize::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }


    public function searchByCliche($id_cliche)
    {
        $query = ClicheSize::find();
        $query->where(['id_cliche'=>$id_cliche]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                    'pageSize' => 200,
                ],
        ]);

        return $dataProvider;
    }
}
