<?php

namespace backend\helpers;

use backend\models\ClichePrice;
use backend\models\StampPrice;
use backend\models\Delivery;
use backend\models\City;
use backend\models\Order;
/**
 *
 */
class OrderHelper
{

  private static $stats_name = [
    Order::STATUS_NEW => 'Новый заказ',
    Order::STATUS_ORDER => 'Заказан',
    Order::STATUS_PAID => 'Оплачен',
    Order::STATUS_DONE => 'Готов',
    Order::STATUS_CLOSE => 'Выполнен',
    Order::STATUS_CANCEL => 'Отменен',
    Order::STATUS_EXPIRED => 'Истек срок',
    Order::STATUS_CASHLESS => 'Безналичный платеж',
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
          Order::STATUS_NEW => '<span class="label label-info">Новый заказ</span>',
          Order::STATUS_ORDER => '<span class="label label-warning">Заказан</span>',
          Order::STATUS_PAID => '<span class="label label-primary">Оплачен</span>',
          Order::STATUS_DONE => '<span class="label label-success">Готов</span>',
          Order::STATUS_CLOSE => '<span class="label label-default">Выполнен</span>',
          Order::STATUS_CANCEL => '<span class="label label-danger">Отменен</span>',
          Order::STATUS_EXPIRED => '<span class="label label-warning">Истек срок</span>',
          Order::STATUS_CASHLESS => '<span class="label label-primary">Безналичный платеж</span>'
      ];
      return $labels[$status];
    }

    public static function countNew()
    {
      return Order::find()->where(['status' => Order::STATUS_NEW])->count();
    }

    public static function countByMonth()
    {
      return Order::find()->count();
    }

    public static function countDone()
    {
      return Order::find()->where(['status' => Order::STATUS_DONE])->count();
    }

    public static function getNumber($model)
    {
      $lastNum = Order::find()->max('number');
      if ($lastNum) {
        return $lastNum + 1;
      }
      return 1000;
    }

    public static function getCost($model)
    {
      $deliveryPrice = 0;
      $cliche = ClichePrice::find()->where(['id_cliche' => $model->cliche_tpl->cliche->id])->andWhere(['id_city' => $model->producer->contact->id_city])->one();
      $stamp = StampPrice::find()->where(['id_stamp' => $model->id_stamp])->andWhere(['id_city' => $model->producer->contact->id_city])->one();
      $clichePrice = $cliche->price;
      if ($model->id_stamp == 20) {
        $stampPrice = 0;
      }else{
        $stampPrice = $stamp->price;
      }

      if ($model->id_delivery == Delivery::TYPE_TO_HAND) {
        if($city = City::findOne($model->producer->contact->id_city)){
          $deliveryPrice = $city->delivery_price;
        }
      }
      $cost =  $clichePrice + $stampPrice + $deliveryPrice;
      return $cost * $model->quantity;
    }
}
