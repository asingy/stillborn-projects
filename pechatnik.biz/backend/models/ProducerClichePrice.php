<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "producer_cliche_price".
 *
 * @property integer $id
 * @property integer $id_producer
 * @property integer $id_stamp_case
 * @property integer $status
 * @property string $info
 */
class ProducerClichePrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'producer_cliche_price';
    }

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_producer', 'id_cliche', 'id_cliche_size', 'price'], 'required'],
            [['id_producer', 'id_cliche', 'id_cliche_size', 'price', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_producer' => 'Id Producer',
            'id_cliche' => 'Печать',
            'id_cliche_size' => 'Размер печати',
            'price' => 'Цена',
            'status' => 'Статус',
        ];
    }

    public function getCliche()
    {
        return $this->hasOne(Cliche::className(), ['id' => 'id_cliche']);
    }

    public function getCliche_size()
    {
        return $this->hasOne(ClicheSize::className(), ['id' => 'id_cliche_size']);
    }
}
