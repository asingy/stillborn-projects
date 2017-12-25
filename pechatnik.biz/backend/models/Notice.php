<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "notice".
 *
 * @property integer $id
 * @property string $subj
 * @property string $body
 * @property integer $triger
 * @property integer $group
 * @property boolean $status
 */
class Notice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notice';
    }

    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subj', 'body', 'status', 'group'], 'required'],
            [['triger', 'group'], 'integer'],
            [['status', 'status'], 'boolean'],
            [['subj', 'body'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subj' => 'Тема',
            'body' => 'Письмо',
            'group' => 'Группа',
            'triger' => 'Тригер',
            'status' => 'Статус',
        ];
    }
}
