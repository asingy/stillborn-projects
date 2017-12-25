<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cliche_tpl".
 *
 * @property integer $id
 * @property integer $id_type
 * @property string $name
 * @property string $sizes
 * @property string $info
 * @property string $image
 * @property string $fields
 * @property integer $status
 * @property integer $order
 */
class ClicheTpl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cliche_tpl';
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
            [['id_cliche', 'sort', 'status'], 'integer'],
            [['name', 'info', 'sizes','fields'], 'string'],
            [['image'], 'image','extensions' => 'svg', 'minWidth' => 150, 'maxWidth' => 200, 'minHeight' => 150, 'maxHeight'=>200,'skipOnEmpty' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cliche' => 'Тип клише',
            'name' => 'Наименование',
            'sizes' => 'Размер мм.',
            'info' => 'Инфо',
            'image' => 'Изображение',
            'status' =>'Статус',
            'sort' => 'Очередь',
            'fields' => 'Поля',

        ];
    }

    public function getCliche()
    {
        return $this->hasOne(Cliche::className(), ['id' => 'id_cliche']);
    }

    public function getTemplate()
    {
        $filepath = Yii::getAlias('@backend-webroot').'/images/cliche_tpl/'.$this->image;

        if (file_exists($filepath)) {
            return file_get_contents($filepath);
        }
        
        return false;
    }
}
