<?php

namespace backend\helpers;

use Yii;
use backend\models\Producer;
use backend\models\ProducerClicheTpl;
use backend\models\ProducerStamp;
use backend\models\ProducerClichePrice;
use yii\helpers\ArrayHelper;

class ProducerHelper
{
  private static $statusName = [
    Producer::STATUS_ACTIVE => 'Активен',
    Producer::STATUS_INACTIVE => 'Не активен',
  ];

  public static function getAllStats()
  {
    return self::$statusName;
  }

  public static function getStatusName($status)
  {
    return self::$statusName[$status];
  }

  public static function getStatusLabels($status)
  {
    $labels = [
        Producer::STATUS_ACTIVE =>'<span class="label label-success">Активен</span>',
        Producer::STATUS_INACTIVE =>'<span class="label label-danger">Не активен</span>',
    ];
    return $labels[$status];
  }

  public static function getAllNames()
  {
    $model = Producer::find()->joinWith('contact')->where(['producer.status'=>Producer::STATUS_ACTIVE])->all();
    return ArrayHelper::map($model, 'id','contact.name');
  }

  public static function getListByCity()
  {
    $model = Producer::find()->joinWith('contact')->where(['producer.status'=>Producer::STATUS_ACTIVE, 'contact.id_city' => Yii::$app->user->identity->id_city])->all();
    return ArrayHelper::map($model, 'id','contact.name');
  }

  public static function getName($id)
  {
    $model = Producer::findOne($id);
    return $model->contact->name;
  }

  public static function getListByAttributes($id_cliche_tpl, $id_stamp)
  {
    $cliche_tpl = ArrayHelper::getColumn(ProducerClicheTpl::find()->where(['id_cliche_tpl'=>$id_cliche_tpl])->all(),'id_producer');
    $stamp = ArrayHelper::getColumn(ProducerStamp::find()->where(['id_stamp'=>$id_stamp])->all(),'id_producer');
    $id_producer = array_intersect($cliche_tpl, $stamp);
    $model = Producer::find()->joinWith('contact')->where(['producer.id'=>$id_producer,'producer.status'=>Producer::STATUS_ACTIVE, 'contact.id_city' => Yii::$app->user->identity->id_city])->all();
    return ArrayHelper::map($model, 'id','contact.name');
  }

  public static function getForSelect($id_cliche_tpl, $id_stamp)
  {
    $list = '';
    foreach (self::getListByAttributes($id_cliche_tpl, $id_stamp) as $key => $value) {
      $list .= '<option value="'.$key.'">'.$value.'</option>';
    }

    return $list;
  }

  public static function getProducerCost($id_producer, $id_cliche, $id_stamp)
  {
    $cliche = ProducerClichePrice::findOne(['id_producer'=> $id_producer, 'id_cliche' => $id_cliche]);
    $stamp = ProducerStamp::findOne(['id_producer'=> $id_producer, 'id_stamp' => $id_stamp]);
    return $cliche->price + $stamp->price;
  }
}
