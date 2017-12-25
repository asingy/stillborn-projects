<?php

namespace backend\helpers;

use Yii;
use backend\models\City;
use yii\helpers\ArrayHelper;
class CityHelper
{

  public static function getAll()
  {
    $model = City::find()->all();
    return ArrayHelper::map($model, 'id','name');
  }

  public static function getById($id)
  {
    $model = City::findOne($id);
    return $model->name;
  }
}
