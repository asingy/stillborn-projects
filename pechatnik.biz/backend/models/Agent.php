<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "agent".
 *
 * @property integer $id
 * @property integer $id_contact
 * @property string $payment_email
 * @property integer $client_delivery
 * @property integer $reward
 * @property Contact $contact
 */
class Agent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agent';
    }
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_contact', 'payment_email', 'client_delivery', 'status'], 'required'],
            [['id_contact', 'client_delivery', 'reward', 'status'], 'integer'],
            [['payment_email'], 'string'],
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
            'payment_email' => 'Email для платежей',
            'client_delivery' => 'Доставка',
            'reward' => 'Вознаграждение',
            'status' =>'Статус',
        ];
    }

    public function getContact()
    {
        return $this->hasOne(Contact::className(), ['id' => 'id_contact']);
    }
}
