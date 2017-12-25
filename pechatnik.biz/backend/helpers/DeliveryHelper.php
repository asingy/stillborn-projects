<?php

namespace backend\helpers;

use Yii;
use backend\models\Delivery;
use backend\models\AgentProducer;
use yii\helpers\ArrayHelper;
class DeliveryHelper
{
  private static $stats_name = [
    Delivery::STATUS_ACTIVE => 'Активен',
    Delivery::STATUS_INACTIVE => 'Не активен',
  ];

  private static $types_name = [
    Delivery::TYPE_TO_HAND => 'Доставка',
    Delivery::TYPE_PICKUP => 'Пункты выдачи',
  ];

  public static function getAllStats()
  {
    return self::$stats_name;
  }

  public static function getAllTypes()
  {
    return self::$types_name;
  }

  public static function getStatusName($status)
  {
    return self::$stats_name[$status];
  }

  public static function getStatusLabels($status)
  {
    $labels = [
        Delivery::STATUS_ACTIVE =>'<span class="label label-success">Активен</span>',
        Delivery::STATUS_INACTIVE =>'<span class="label label-danger">Не активен</span>',
    ];
    return $labels[$status];
  }

  public static function getAllNames()
  {
    $model = Delivery::find()->where(['status'=>Delivery::STATUS_ACTIVE])->all();
    return ArrayHelper::map($model, 'id','name');
  }

  public static function getName($id)
  {
    $model = Delivery::findOne($id);
    return $model->name;
  }

  public static function getListByProducer($id_producer)
  {
    $prod_addrs = ArrayHelper::map(Delivery::find()->where(['id_producer'=>$id_producer])->all(), 'id', 'address');
    $id_agents = ArrayHelper::getColumn(AgentProducer::find()->where(['id_producer'=>$id_producer])->all(), 'id_agent');
    $agent_addrs = ArrayHelper::map(Delivery::find()->where(['id_agent'=>$id_agents])->all(), 'id', 'address');
    return $prod_addrs + $agent_addrs;
  }
}
