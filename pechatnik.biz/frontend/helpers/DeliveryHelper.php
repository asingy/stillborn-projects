<?php
namespace frontend\helpers;

use Yii;
use backend\models\Delivery;
use yii\helpers\ArrayHelper;
use backend\models\Agent;
use backend\models\AgentProducer;
use frontend\helpers\OrderHelper;

/**
 * Helper
 */
class DeliveryHelper
{
  private static $types_name = [
    Delivery::TYPE_TO_HAND => 'Доставка',
    Delivery::TYPE_PICKUP => 'Пункты выдачи',
  ];

  public static function getAllTypes()
  {
    return self::$types_name;
  }

  public static function getDeliveryType($type)
  {
    return self::$types_name[$type];
  }

  public static function getDeliveryAddress($address)
  {
    if (is_numeric($address)) {
      return Delivery::findOne($address)->address;
    }
    return $address;
  }

  public static function getList()
  {
    $id_producer = OrderHelper::getProduserByAttributes(Yii::$app->session['data_step2'], Yii::$app->session['data_step4']);
    $prod_addrs = ArrayHelper::map(Delivery::find()->where(['id_producer'=>$id_producer])->all(), 'id', 'address');
    $id_agents = ArrayHelper::getColumn(AgentProducer::find()->where(['id_producer'=>$id_producer])->all(), 'id_agent');
    $agent_addrs = ArrayHelper::map(Delivery::find()->where(['id_agent'=>$id_agents])->all(), 'id', 'address');
    return  $prod_addrs + $agent_addrs;
    // return [];
  }

  public static function getListByAgent()
  {
    $agent = Agent::find()->joinWith('contact')->where(['contact.id_city' => 1])->one();
    return ArrayHelper::map(Delivery::find()->where(['id_agent'=>$agent->id])->all(), 'id', 'address');
  }
}
