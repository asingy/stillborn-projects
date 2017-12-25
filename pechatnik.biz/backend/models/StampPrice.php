<?php

namespace backend\models;

use Yii;
use backend\models\StampCases;

/**
 * This is the model class for table "stamp_price".
 *
 * @property integer $id
 * @property integer $id_stamp_case
 * @property integer $id_city
 * @property integer $price
 * @property integer $status
 * @property string $info
 */
class StampPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stamp_price';
    }
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_stamp', 'id_city', 'price'], 'required'],
            [['id_stamp', 'id_city', 'price', 'status'], 'integer'],
            [['info'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_stamp' => 'Оснастка',
            'id_city' => 'Город',
            'price' => 'Цена',
            'status' => 'Статус',
            'info' => 'Инфо',
        ];
    }

    public function getStamp()
    {
        return $this->hasOne(Stamp::className(), ['id' => 'id_stamp']);
    }
}
