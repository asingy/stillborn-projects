<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "agent_delivery".
 *
 * @property integer $id
 * @property integer $id_agent
 * @property integer $id_producer
 * @property integer $status
 * @property string $info
 */
class AgentDelivery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agent_delivery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_agent', 'id_delivery', 'status', 'info'], 'required'],
            [['id_agent', 'id_delivery', 'status'], 'integer'],
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
            'id_delivery' => 'Id Delivery',
            'status' => 'Status',
            'info' => 'Info',
        ];
    }
}
