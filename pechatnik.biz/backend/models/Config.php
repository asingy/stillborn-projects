<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $name
 * @property string $param
 * @property integer $status
 * @property string $info
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const TYPE_BACKEND = 1;
    const TYPE_FRONTEND = 2;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'param', 'status','type'], 'required'],
            [['name', 'param', 'param2','info'], 'string'],
            [['status','type'], 'integer'],
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
            'param' => 'Параметр 1',
            'param2' => 'Параметр 2',
            'status' => 'Статус',
            'info' => 'Инфо',
        ];
    }
}
