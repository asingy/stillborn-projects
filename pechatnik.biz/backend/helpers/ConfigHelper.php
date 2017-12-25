<?php

namespace backend\helpers;

use Yii;
use backend\models\Config;
use yii\helpers\ArrayHelper;
class ConfigHelper
{
  private static $stats_name = [
    Config::STATUS_ACTIVE => 'Активен',
    Config::STATUS_INACTIVE => 'Не активен',
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
        Config::STATUS_ACTIVE =>'<span class="label label-success">Активен</span>',
        Config::STATUS_INACTIVE =>'<span class="label label-danger">Не активен</span>',
    ];
    return $labels[$status];
  }

  public static function getAllNames()
  {
    $model = Config::find()->where(['status'=>Config::STATUS_ACTIVE])->all();
    return ArrayHelper::map($model, 'id','name');
  }

  public static function getName($id)
  {
    $model = Config::findOne($id);
    return $model->name;
  }

  public static function getParamsByType($type)
  {
    $conf = Config::findAll(['type'=>$type]);
    $data = [];
    foreach ($conf as $key => $value) {
      $arr = explode(".", $value->name);
      if ($arr[0] === 'faq') {
        $data[$arr[0]][$arr[1]] = $value->param;
      }
      if ($arr[0] === 'contacts') {
        $data[$arr[0]][$arr[1]] = $value->param;
      }
      if ($arr[0] === 'promo') {
        $data[$arr[0]] = [$arr[1] => $value->param];
      }
    }
    return $data;
  }

  public static function getClicheTplFieldsList()
  {
    $conf = Config::findAll(['type'=>Config::TYPE_BACKEND]);
    $data = [];
    foreach ($conf as $key => $value) {
      $arr = explode(".", $value->name);
      if ($arr[0] === 'cliche_tpl' && $arr[1] === 'fields') {
        $data[$arr[2]] = $value->param;
      }
    }
    return $data;
  }

  public static function getClicheTplFieldsForSelect()
  {
    $conf = Config::findAll(['type'=>Config::TYPE_BACKEND]);
    $data = [];
    foreach ($conf as $key => $value) {
      $arr = explode(".", $value->name);
      if ($arr[0] === 'cliche_tpl' && $arr[1] === 'fields') {
        $data[$arr[2]] = $value->info;
      }
    }
    return $data;
  }
}
