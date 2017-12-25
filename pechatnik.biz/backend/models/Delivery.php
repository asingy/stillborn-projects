<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "delivery".
 *
 * @property integer $id
 * @property integer $id_producer
 * @property string $address
 * @property integer $status
 * @property string $info
 */
class Delivery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delivery';
    }
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const TYPE_TO_HAND = 1;
    const TYPE_PICKUP = 2;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address', 'status', 'id_city'], 'required'],
            [['id_producer', 'status', 'id_agent', 'id_city'], 'integer'],
            [['address', 'info'], 'string'],
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
            'id_city' => 'Город',
            'address' => 'Адрес',
            'status' => 'Статус',
            'info' => 'Инфо',
        ];
    }
}
