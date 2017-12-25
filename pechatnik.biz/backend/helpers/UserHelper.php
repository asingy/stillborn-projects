<?php

namespace backend\helpers;

use Yii;
use backend\models\User;
use yii\helpers\ArrayHelper;

class UserHelper
{
  private static $stats_name = [
    User::STATUS_DELETED => 'Удалён',
    User::STATUS_INACTIVE => 'Не активен',
    User::STATUS_ACTIVE => 'Активен',
    User::STATUS_SUSPENDED => 'Приостановлен',
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
        User::STATUS_ACTIVE =>'<span class="label label-success">Активен</span>',
        User::STATUS_INACTIVE =>'<span class="label label-warning">Не активен</span>',
        User::STATUS_SUSPENDED =>'<span class="label label-warning">Приостановлен</span>',
        User::STATUS_DELETED =>'<span class="label label-danger">Удален</span>',
    ];
    return $labels[$status];
  }

  public static function getAllUsersByCity()
  {
    return ArrayHelper::map(User::findAll(['id_city' => Yii::$app->user->identity->id_city]), 'id', 'description');
  }

  public static function getAllUsers()
  {
    $front[0] = 'Фронтенд';
    $users = ArrayHelper::map(User::findAll(['id_city' => Yii::$app->user->identity->id_city]), 'id', 'description');
    return array_merge($front, $users);
  }

  public static function getDescriptionById($id)
  {
    $model = User::findIdentity($id);
    return $model->description;
  }
}
