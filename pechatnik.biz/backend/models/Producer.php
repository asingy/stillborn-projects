<?php

namespace backend\models;

use Yii;
use backend\models\Contacts;

/**
 * This is the model class for table "producer".
 *
 * @property integer $id
 * @property integer $id_contact
 * @property integer $urgency
 * @property integer $need_scan_docs
 * @property integer $is_default
 * @property Contact $contact
 */
class Producer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'producer';
    }
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const DEFAULT = 1;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_contact', 'need_scan_docs', 'is_default', 'status'], 'required'],
            [['id_contact', 'urgency', 'need_scan_docs', 'is_default', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_contact' => 'Id Contact',
            'urgency' => 'Срочность',
            'need_scan_docs' => 'Сканы документов',
            'is_default' => 'По умолчанию',
            'status' => 'Статус',
        ];
    }

    public function getContact()
    {
        return $this->hasOne(Contact::className(), ['id' => 'id_contact']);
    }

    public function getStamp()
    {
      return $this->hasMany(Stamp::className(), ['id' => 'id_stamp'])
      ->viaTable('producer_stamp', ['id_producer' => 'id']);
    }
}
