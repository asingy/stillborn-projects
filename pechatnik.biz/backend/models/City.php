<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property string $name
 * @property string $cname
 * @property string $code
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
    }
    const DEFAULT_CITY_ID = 1;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'delivery_price', 'reward'], 'required'],
            [['delivery_price', 'reward'], 'integer'],
            [['name', 'cname', 'code'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Город',
            'cname' => 'Инфо',
            'code' => 'Код',
            'delivery_price' => 'Цена доставки р.',
            'reward' => 'Вознаграждение системы',
        ];
    }
}
