<?php

namespace common\models;

use backend\models\ClicheTpl;
use Yii;

/**
 * This is the model class for table "{{%template_settings}}".
 *
 * @property int $id
 * @property int $template_id
 * @property string $field
 * @property double $radius
 * @property double $start
 * @property double $end
 * @property boolean $inner
 * @property string $selector
 * @property string $prefix
 * @property double $x
 * @property double $y
 * @property boolean $mirror
 * @property double $radius_mirror
 * @property double $start_mirror
 * @property double $end_mirror
 * @property boolean $mirror2
 * @property double $radius_mirror2
 * @property double $start_mirror2
 * @property double $end_mirror2
 *
 * @property ClicheTpl $template
 */
class TemplateSettings extends \yii\db\ActiveRecord
{
    public $angles;
    public $angles_mirror;
    public $angles_mirror2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%template_settings}}';
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->angles = $this->getAngles();
        $this->angles_mirror = $this->getAnglesMirror();
        $this->angles_mirror2 = $this->getAnglesMirror2();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'field', 'radius', 'angles', 'selector'], 'required'],
            [['template_id'], 'integer'],
            [['inner', 'mirror', 'mirror2'], 'boolean'],
            [['radius', 'start', 'end', 'radius_mirror', 'start_mirror', 'end_mirror', 'radius_mirror2', 'start_mirror2', 'end_mirror2', 'x', 'y'], 'number'],
            [['field', 'selector', 'prefix'], 'string', 'max' => 255],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClicheTpl::className(), 'targetAttribute' => ['template_id' => 'id']],
            [['angles', 'angles_mirror', 'angles_mirror2'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template_id' => 'Template ID',
            'field' => 'Поле',
            'radius' => 'Радиус',
            'start' => 'Начало',
            'end' => 'Конец',
            'radius_mirror' => 'Радиус (копия)',
            'start_mirror' => 'Начало (копия)',
            'end_mirror' => 'Конец (копия)',
            'radius_mirror2' => 'Радиус (копия 2)',
            'start_mirror2' => 'Начало (копия 2)',
            'end_mirror2' => 'Конец (копия 2)',
            'angles' => 'Положение текста',
            'angles_mirror' => 'Положение текста (копия)',
            'angles_mirror2' => 'Положение текста (копия 2)',
            'inner' => 'Вывернуть текст',
            'selector' => 'Селектор',
            'prefix' => 'Префикс',
            'x' => 'X',
            'y' => 'Y',
            'mirror' => 'Зеркальное отображение',
            'mirror2' => 'Зеркальное отображение 2'
        ];
    }

    public function beforeSave($insert)
    {
        $coords = explode(',', $this->angles);
        $coords_mirror = explode(',', $this->angles_mirror);
        $coords_mirror2 = explode(',', $this->angles_mirror2);

        if ($coords) {
            $this->start = $coords[0];
            $this->end = $coords[1];
        }

        if ($coords_mirror) {
            $this->start_mirror = $coords_mirror[0];
            $this->end_mirror = $coords_mirror[1];
        }

        if ($coords_mirror2) {
            $this->start_mirror2 = $coords_mirror2[0];
            $this->end_mirror2 = $coords_mirror2[1];
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(ClicheTpl::className(), ['id' => 'template_id']);
    }

    public static function findByTemplateAndField($template, $field)
    {
        return static::findOne(['template_id' => $template, 'field' => $field]);
    }

    public function getAngles()
    {
        if ($this->start && $this->end) {
            return $this->start.','.$this->end;
        }

        return null;
    }

    public function getAnglesMirror()
    {
        if ($this->start_mirror && $this->end_mirror) {
            return $this->start_mirror.','.$this->end_mirror;
        }

        return null;
    }

    public function getAnglesMirror2()
    {
        if ($this->start_mirror2 && $this->end_mirror2) {
            return $this->start_mirror2.','.$this->end_mirror2;
        }

        return null;
    }

    public function getSelector()
    {
        $selectors = explode(',', $this->selector);

        if (count($selectors) > 1 && $this->mirror) {
            return $selectors;
        }

        if (!empty($this->selector)) {
            return $this->selector;
        }

        return null;
    }
}
