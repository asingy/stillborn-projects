<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "agent_producer".
 *
 * @property integer $id
 * @property integer $id_agent
 * @property integer $id_producer
 * @property integer $status
 * @property string $info
 * @property Agent $agent
 * @property Producer $producer
 */
class AgentProducer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agent_producer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_agent', 'id_producer'], 'required'],
            [['id_agent', 'id_producer', 'status'], 'integer'],
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
            'id_agent' => 'Id Agent',
            'id_producer' => 'Id Producer',
            'status' => 'Status',
            'info' => 'Info',
        ];
    }

    public function getProducer()
    {
        return $this->hasOne(Producer::className(), ['id' => 'id_producer']);
    }

    public function getAgent()
    {
        return $this->hasOne(Agent::className(), ['id' => 'id_agent']);
    }
}
