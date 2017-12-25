<?php

namespace backend\helpers;

use Yii;
use backend\models\Payment;
use yii\helpers\ArrayHelper;
class PaymentHelper
{
  
  private static $stats_name = [
    Payment::STATUS_ACTIVE => 'Активен',
    Payment::STATUS_INACTIVE => 'Не активен',
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
        Payment::STATUS_ACTIVE =>'<span class="label label-success">Активен</span>',
        Payment::STATUS_INACTIVE =>'<span class="label label-danger">Не активен</span>',
    ];
    return $labels[$status];
  }

  public static function getAllNames()
  {
    $model = Payment::find()->where(['status'=>Payment::STATUS_ACTIVE])->all();
    return ArrayHelper::map($model, 'id','name');
  }

  public static function getName($id)
  {
    $model = Payment::findOne($id);
    return $model->name;
  }
  
  public static function getMethods()
  {
    return [
        'AC' => 'Банковская карта',
        'PC' => 'Яндекс.Деньги',
        'QW' => 'QIWI Кошелек',
        'AB' => 'Альфа-Клик',
        'WM' => 'WebMoney',
        'MA' => 'MasterPass'
    ];
  }

  public static function isPay($id)
  {
    return isset(static::getMethods()[$id]);
  }
  
}
