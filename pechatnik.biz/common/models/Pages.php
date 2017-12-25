<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%pages}}".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $content
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property int $author_id
 * @property int $created_at
 * @property int $updated_at
 */
class Pages extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => function() {
                    return time();
                }
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'author_id',
                'updatedByAttribute' => false
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['content'], 'string'],
            [['author_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'slug', 'meta_title', 'meta_keywords', 'meta_description'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'slug' => 'Алиас',
            'content' => 'Содержимое',
            'meta_title' => 'Заголовок',
            'meta_keywords' => 'Ключевые слова',
            'meta_description' => 'Описание',
            'author_id' => 'Автор',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    public static function findBySlug($slug)
    {
        return self::findOne(['slug' => $slug]);
    }
}
