<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "stamp".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property string $image
 * @property string $info
 * @property integer $sort
 */
class Stamp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stamp';
    }
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const DELETED = 1;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['name', 'image', 'info'], 'string'],
            [['status', 'sort'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'status' => 'Статус',
            'image' => 'Изображение',
            'info' => 'Инфо',
            'sort' => 'Очередь',
        ];
    }

    public function getStamp_price()
    {
        return $this->hasOne(StampPrice::className(), ['id_stamp' => 'id']);
    }
}
