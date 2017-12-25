<?php

namespace backend\helpers;

use Yii;
use backend\models\Agent;
use yii\helpers\ArrayHelper;

class AgentHelper
{
  private static $stats_name = [
    Agent::STATUS_ACTIVE => 'Активен',
    Agent::STATUS_INACTIVE => 'Не активен',
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
        Agent::STATUS_ACTIVE =>'<span class="label label-success">Активен</span>',
        Agent::STATUS_INACTIVE =>'<span class="label label-danger">Не активен</span>',
    ];
    return $labels[$status];
  }

  public static function getAllNames()
  {
    $model = Agent::find()->where(['status'=>Agent::STATUS_ACTIVE])->all();
    $arr = [];
    foreach ($model as $value) {
      $arr[$value->id] = $value->contact->name;
    }
    return $arr;
    // return ArrayHelper::map($model, 'id','name');
  }

  public static function getName($id)
  {
    $model = Agent::findOne($id);
    return $model->contacts->name;
  }
}
