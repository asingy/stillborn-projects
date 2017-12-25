<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property integer $id
 * @property string $name
 * @property integer $id_city
 * @property string $address
 * @property string $email
 * @property string $phone
 * @property string $info
 * @property integer $status
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client';
    }

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'id_city', 'phone', 'status'], 'required'],
            [['id_city', 'status'], 'integer'],
            [['address', 'info', 'name', 'phone', 'email'], 'string'],
            // ['phone', 'string', 'max'=>10, 'tooLong'=>'Максимальное кол-во 10 цифр'],
            // ['phone', 'string', 'min'=>6, 'tooShort'=>'Минимальное кол-во 6 цифр'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'id_city' => 'Город',
            'address' => 'Адрес',
            'phone' => 'Телефон',
            'email' => 'Email',
            'info' => 'Инфо',
            'status' => 'Статус',
        ];
    }
}
