<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property integer $id
 * @property integer $id_city
 * @property string $name
 * @property string $cname
 * @property string $inn
 * @property string $ogrn
 * @property string $address
 * @property string $contact_person
 * @property integer $contact_phone
 * @property integer $bot_phone
 * @property string $delivery_address
 * @property string $email
 * @property string $info
 * @property integer $type
 * @property integer $status
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }
    const TYPE_PRODUCER = 1;
    const TYPE_AGENT = 2;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_city', 'name', 'cname', 'inn', 'ogrn', 'address', 'contact_person', 'contact_phone', 'delivery_address', 'email', 'type'], 'required'],
            [['id_city', 'type', 'status'], 'integer'],
            [['name', 'cname', 'address', 'contact_person', 'delivery_address', 'email', 'info', 'contact_phone', 'bot_phone', 'inn', 'ogrn'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_city' => 'Город',
            'name' => 'Наименование',
            'cname' => 'Псевдоним',
            'inn' => 'ИНН',
            'ogrn' => 'ОГРН',
            'address' => 'Адрес',
            'contact_person' => 'Контактное лицо',
            'contact_phone' => 'Контактный телефон',
            'bot_phone' => 'Телеграм телефон',
            'delivery_address' => 'Delivery Address',
            'email' => 'Email',
            'info' => 'Инфо',
            'type' => 'Type',
            'status' => 'Статус',
        ];
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'id_city']);
    }
}
