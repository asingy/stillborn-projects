<?php

namespace backend\models;

use Yii;
use backend\models\StampTypes;
/**
 * This is the model class for table "cliche_price".
 *
 * @property integer $id
 * @property integer $id_stamp_type
 * @property integer $id_city
 * @property integer $price
 * @property integer $status
 * @property string $info
 */
class ClichePrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cliche_price';
    }
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cliche', 'id_city', 'price','id_cliche_size'], 'required'],
            [['id_cliche', 'id_city', 'price', 'status','id_cliche_size'], 'integer'],
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
            'id_cliche' => 'Печать',
            'id_city' => 'Город',
            'price' => 'Цена',
            'status' => 'Статус',
            'info' => 'Инфо',
            'id_cliche_size' => 'Размер печати',
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
