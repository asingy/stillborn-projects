<?php

namespace backend\helpers;

use Yii;
use backend\models\ClichePrice;
use yii\helpers\ArrayHelper;
class ClichePriceHelper
{
  private static $stats_name = [
    ClichePrice::STATUS_ACTIVE => 'Активен',
    ClichePrice::STATUS_INACTIVE => 'Не активен',
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
        ClichePrice::STATUS_ACTIVE =>'<span class="label label-success">Активен</span>',
        ClichePrice::STATUS_INACTIVE =>'<span class="label label-danger">Не активен</span>',
    ];
    return $labels[$status];
  }

  public static function getAllNames()
  {
    $model = ClichePrice::find()->where(['status' => ClichePrice::STATUS_ACTIVE])->all();
    return ArrayHelper::map($model, 'id','name');
  }

  public static function getName($id)
  {
    $model = ClichePrice::findOne($id);
    return $model->name;
  }

  public static function checkPrice($id_cliche, $id_cliche_size)
  {
    $model = ClichePrice::find()->where(['id_cliche'=>$id_cliche,'id_cliche_size'=>$id_cliche_size])->one(); //,'status' => ClichePrice::STATUS_ACTIVE
    if (!empty($model) && $model->price != 0) {
      return true;
    }
    return false;
  }


}
