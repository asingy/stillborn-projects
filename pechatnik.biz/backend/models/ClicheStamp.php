<?php

namespace backend\models;
use backend\models\StampCses;
use Yii;

/**
 * This is the model class for table "cliche_stamp".
 *
 * @property integer $id
 * @property integer $id_stamp
 * @property integer $id_case
 * @property integer $status
 * @property string $info
 */
class ClicheStamp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cliche_stamp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_stamp', 'id_cliche'], 'required'],
            [['id_stamp', 'id_cliche', 'status'], 'integer'],
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
            'id_stamp' => 'Id Stamp',
            'id_cliche' => 'Id cliche',
            'status' => 'Status',
            'info' => 'Info',
        ];
    }

    public function getStamp()
    {
        return $this->hasOne(Stamp::className(), ['id' => 'id_stamp']);
    }

    public function getCliche_size_stamp()
    {
        return $this->hasMany(ClicheSizeStamp::className(), ['id_cliche_stamp' => 'id']);
    }
}
