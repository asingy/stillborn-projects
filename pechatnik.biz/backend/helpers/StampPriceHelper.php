<?php

namespace backend\helpers;

use Yii;
use backend\models\StampPrice;
use yii\helpers\ArrayHelper;
class StampPriceHelper
{
  private static $stats_name = [
    StampPrice::STATUS_ACTIVE => 'Активен',
    StampPrice::STATUS_INACTIVE => 'Не активен',
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
        StampPrice::STATUS_ACTIVE =>'<span class="label label-success">Активен</span>',
        StampPrice::STATUS_INACTIVE =>'<span class="label label-danger">Не активен</span>',
    ];
    return $labels[$status];
  }

  public static function getAllNames()
  {
    $model = StampPrice::find()->where(['status' => StampPrice::STATUS_ACTIVE])->all();
    return ArrayHelper::map($model, 'id','name');
  }

  public static function getName($id)
  {
    $model = StampPrice::findOne($id);
    return $model->name;
  }

  public static function checkPrice($id_stamp)
  {
    $model = StampPrice::find()->where(['id_stamp'=>$id_stamp])->one(); //,'status' => StampPrice::STATUS_ACTIVE
    if (!empty($model) && $model->price != 0) {
      return true;
    }
    return false;
  }

    public static function getPrice($id_stamp)
    {
        $model = StampPrice::find()->where(['id_stamp'=>$id_stamp])->one(); //,'status' => StampPrice::STATUS_ACTIVE
        if (!empty($model) && $model->price != 0) {
            return $model->price.' руб.';
        }
        return false;
    }


}
