<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "producer_cliche_tpl".
 *
 * @property integer $id
 * @property integer $id_producer
 * @property integer $id_cliche_tpl
 * @property integer $status
 * @property string $info
 */
class ProducerClicheTpl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'producer_cliche_tpl';
    }
    const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_producer', 'id_cliche_tpl'], 'required'],
            [['id_producer', 'id_cliche_tpl', 'status'], 'integer'],
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
            'id_producer' => 'Id Producer',
            'id_cliche_tpl' => 'Id Stamp Tpl',
            'status' => 'Status',
            'info' => 'Info',
        ];
    }

    public function getCliche_tpl()
    {
        return $this->hasOne(ClicheTpl::className(), ['id' => 'id_cliche_tpl']);
    }
}
