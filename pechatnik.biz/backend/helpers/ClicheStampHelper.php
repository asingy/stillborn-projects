<?php

namespace backend\helpers;

use Yii;
use backend\models\Stamp;
use backend\models\ClicheStamp;
use yii\helpers\ArrayHelper;
class ClicheStampHelper
{
  private static $stats_name = [
    ClicheStamp::STATUS_ACTIVE => 'Активен',
    ClicheStamp::STATUS_INACTIVE => 'Не активен',
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
        ClicheStamp::STATUS_ACTIVE =>'<span class="label label-success">Активен</span>',
        ClicheStamp::STATUS_INACTIVE =>'<span class="label label-danger">Не активен</span>',
    ];
    return $labels[$status];
  }

  public static function getAllNames()
  {
    $model = ClicheStamp::find()->where(['status'=>ClicheStamp::STATUS_ACTIVE])->all();
    return ArrayHelper::map($model, 'id','name');
  }

  public static function getName($id)
  {
    $model = ClicheStamp::findOne($id);
    return $model->name;
  }

}
