<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cliche_size_stamp".
 *
 * @property integer $id
 * @property integer $id_cliche
 * @property integer $id_cliche_stamp
 * @property string  $id_cliche_size
 */
class ClicheSizeStamp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cliche_size_stamp';
    }
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cliche_size', 'id_cliche_stamp', 'id_cliche'], 'required'],
            [['id_cliche_size', 'id_cliche_stamp', 'id_cliche'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cliche' => 'Cliche',
            'id_cliche_size' => 'Размеры печати',
            'id_cliche_stamp' => 'Stamp Case',
        ];
    }

    public function getCliche_size()
    {
        return $this->hasOne(ClicheSize::className(), ['id' => 'id_cliche_size']);
    }
}
