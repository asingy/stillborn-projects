<?php

namespace backend\helpers;

use Yii;
use backend\models\Cliche;
use yii\helpers\ArrayHelper;
class ClicheHelper
{
  private static $stats_name = [
    Cliche::STATUS_ACTIVE => 'Активен',
    Cliche::STATUS_INACTIVE => 'Не активен',
  ];

  public static function getAllStats()
  {
    return self::$stats_name;
  }

  public static function getStatusName($status)
  {
    return self::$stats_name[$status];
  }

  public static function getStatusLabels($status)
  {
    $labels = [
        Cliche::STATUS_ACTIVE =>'<span class="label label-success">Активен</span>',
        Cliche::STATUS_INACTIVE =>'<span class="label label-danger">Не активен</span>',
    ];
    return $labels[$status];
  }

  public static function getAllNames()
  {
    $model = Cliche::find()->where(['status' => Cliche::STATUS_ACTIVE])->all();
    return ArrayHelper::map($model, 'id','name');
  }

  public static function getName($id)
  {
    $model = Cliche::findOne($id);
    return $model->name;
  }

  
}
