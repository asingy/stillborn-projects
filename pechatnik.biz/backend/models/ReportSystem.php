<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "report_system".
 *
 * @property integer $id
 * @property string $order_number
 * @property string $date
 * @property integer $id_producer
 * @property integer $id_agent
 * @property integer $system_reward
 * @property integer $status
 */
class ReportSystem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $date_from;
     public $date_to;
    public static function tableName()
    {
        return 'report_system';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_number', 'id_producer', 'id_agent', 'system_reward'], 'required'],
            [['date'], 'safe'],
            [['id_producer', 'id_agent', 'system_reward', 'status'], 'integer'],
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
            'id_agent' => 'Агент',
            'system_reward' => 'Вознаграждение системы',
            'status' => 'Статус',
        ];
    }

    public function getProducer()
    {
      return $this->hasOne(Producer::className(), ['id' => 'id_producer']);
    }

    public function getAgent_producer()
    {
      return $this->hasOne(AgentProducer::className(), ['id_producer' => 'id_producer']);
    }
}
