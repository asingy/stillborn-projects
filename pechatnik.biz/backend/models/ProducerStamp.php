<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "producer_stamp".
 *
 * @property integer $id
 * @property integer $id_producer
 * @property integer $id_stamp_case
 * @property integer $status
 * @property string $info
 */
class ProducerStamp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'producer_stamp';
    }
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_producer', 'id_stamp'], 'required'],
            [['id_producer', 'id_stamp', 'status', 'price'], 'integer'],
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
            'id_stamp' => 'Id Stamp',
            'status' => 'Статус',
            'price' => 'Цена',
        ];
    }

    public function getStamp()
    {
        return $this->hasOne(Stamp::className(), ['id' => 'id_stamp']);
    }

    public function getCliche_stamp()
    {
        return $this->hasOne(ClicheStamp::className(), ['id_stamp' => 'id_stamp']);
    }
}
