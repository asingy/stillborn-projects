<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "cliche_size".
 *
 * @property integer $id
 * @property integer $id_stamp_type
 * @property integer $id_stamp_case
 * @property string  $size
 * @property string  $image
 */
class ClicheSize extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cliche_size';
    }
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cliche','size'], 'required'],
            [['size', 'image'], 'string'],
            [['id_cliche'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cliche' => 'Stamp Type',
            'size' => 'Размер',
            'image' => 'Изображение'
        ];
    }

    /**
     * Displays a single StampTemplates model.
     * @param string $previous_image
     * @return mixed
     * @internal param int $id
     */
    public function saveImage($previous_image = '')
    {
        $image = UploadedFile::getInstanceByName('image');
        if ($image) {
            $file = pathinfo($image->name);
            $filename = uniqid().'.'.$file['extension'];
            $path = Yii::getAlias('@webroot').'/images/cliche_tpl/';
            if($image->saveAs($path.$filename)){
                if ($previous_image !== '') {
                    unlink($path . $previous_image);
                }
                return $filename;
            }
        }else{
            return '';
        }
    }
    
    public function getTemplate()
    {
        if ($this->image) {
            $filepath = Yii::getAlias('@backend-webroot').'/images/cliche_tpl/'.$this->image;

            if (file_exists($filepath)) {
                return file_get_contents($filepath);
            }
        }

        return false;
    }
}
