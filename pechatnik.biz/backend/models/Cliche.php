<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cliche".
 *
 * @property integer $id
 * @property string $name
 * @property string $info
 * @property string $image
 * @property integer $status
 * @property integer $order
 */
class Cliche extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cliche';
    }

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['name', 'info'], 'string'],
            [['image'], 'image','extensions' => 'svg', 'minWidth' => 150, 'maxWidth' => 200, 'minHeight' => 150, 'maxHeight'=>200,'skipOnEmpty' => true],
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
            'info' => 'Инфо',
            'image' => 'Изображение',
            'status' => 'Статус',
            'sort' => 'Очередь',
        ];
    }



}
