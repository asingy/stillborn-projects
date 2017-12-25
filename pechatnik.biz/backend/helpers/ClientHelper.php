<?php

namespace backend\helpers;

use Yii;
use backend\models\Client;
use yii\helpers\ArrayHelper;
class ClientHelper
{
  private static $stats_name = [
    Client::STATUS_ACTIVE => 'Активен',
    Client::STATUS_INACTIVE => 'Не активен',
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
        Client::STATUS_ACTIVE =>'<span class="label label-success">Активен</span>',
        Client::STATUS_INACTIVE =>'<span class="label label-danger">Не активен</span>',
    ];
    return $labels[$status];
  }

  public static function getAllNames()
  {
    $model = Client::find()->where(['status'=>Client::STATUS_ACTIVE])->all();
    return ArrayHelper::map($model, 'id','name');
  }

  public static function getName($id)
  {
    $model = Client::findOne($id);
    return $model->name;
  }
}
