<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property integer $id_user_from
 * @property integer $id_user_to
 * @property integer $is_feedback
 * @property string $text
 * @property integer $status
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    const STATUS_NEW = 0;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user_to', 'text'], 'required'],
            [['id_user_from', 'id_user_to', 'is_feedback', 'status'], 'integer'],
            [['text', 'date', 'info'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user_from' => 'От',
            'id_user_to' => 'Кому',
            'is_feedback' => 'Фидбэк',
            'text' => 'Сообщение',
            'date' =>'Дата',
            'status' => 'Status',
            'info' => 'Инфо',
        ];
    }
}
