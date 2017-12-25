<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "report_agent".
 *
 * @property integer $id
 * @property string $order_number
 * @property string $date
 * @property integer $id_producer
 * @property integer $cost_producer
 * @property integer $cost_client
 * @property integer $system_reward
 * @property integer $agent_profit
 * @property integer $status
 */
class ReportAgent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $date_from;
     public $date_to;
    public static function tableName()
    {
        return 'report_agent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_number', 'id_producer', 'cost_producer', 'cost_client', 'system_reward', 'agent_profit'], 'required'],
            [['date'], 'safe'],
            [['id_producer', 'cost_producer', 'cost_client', 'system_reward', 'agent_profit', 'status'], 'integer'],
            [['order_number'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_number' => '№ Заказа',
            'date' => 'Дата',
            'id_producer' => 'Изготовитель',
            'cost_producer' => 'Сумма изготовителя',
            'cost_client' => 'Оплачено клиентом',
            'system_reward' => 'Вознаграждение системы',
            'agent_profit' => 'Прибыль агента',
            'status' => 'Статус',
        ];
    }

    public function getProducer()
    {
      return $this->hasOne(Producer::className(), ['id' => 'id_producer']);
    }
}
