<?php
namespace frontend\helpers;

use Yii;
use backend\models\Config;
use backend\models\Order;
use frontend\models\ClicheTpl;
use backend\models\Stamp;
use backend\models\City;
use backend\helpers\PaymentHelper;

use yii\helpers\ArrayHelper;
use backend\models\Producer;
use backend\models\ProducerClicheTpl;
use backend\models\ProducerStamp;

/**
 * Helper
 */
class OrderHelper
{

  public function urgencyList()
  {
    $urgency = Config::find()->where(['type'=>Config::TYPE_BACKEND, 'name' => 'order.urgency'])->one();
    $arr = explode(',', $urgency->param);
    $list = [];
    foreach ($arr as $key => $value) {
      $list[$key] = $value . ' р.дней';
    }
    return $list;
  }

  public static function getPayment($id_payment)
  {
    return PaymentHelper::getName($id_payment);
  }

  public static function getNumber()
  {
    $lastNum = Order::find()->max('number');
    if ($lastNum) {
      return $lastNum + 1;
    }
    return 1000;
  }

  public static function getProduserByAttributes($id_cliche_tpl, $id_stamp)
  {
    $cliche_tpl = ArrayHelper::getColumn(ProducerClicheTpl::find()->where(['id_cliche_tpl'=>$id_cliche_tpl])->all(),'id_producer');
    $stamp = ArrayHelper::getColumn(ProducerStamp::find()->where(['id_stamp'=>$id_stamp])->all(),'id_producer');
    $id_producer = array_intersect($cliche_tpl, $stamp);
    $model = Producer::find()->joinWith('contact')->where(['producer.id'=>$id_producer,'producer.status'=>Producer::STATUS_ACTIVE, 'contact.id_city' => City::DEFAULT_CITY_ID])->all();
    if($model){
        foreach ($model as $key => $value) {
          if ($value->is_default == Producer::DEFAULT) {
            return $value->id;
          }
          return $value->id;
        }
    }
    return 0;
  }

  public static function getFinalData()
  {
    $stamp = Stamp::findOne(Yii::$app->session['data_step4']);
    $clicheTpl = ClicheTpl::find()->active()->where(Yii::$app->session['data_step2'])->one();

    $data['cliche_image'] = $clicheTpl->image;
    $data['cliche_size'] = Yii::$app->session['data_step3']['size'];
    $data['stamp_image'] = $stamp->image;
    $data['stamp_name'] =  $stamp->name;
    $data['terms'] = Config::findOne(['name'=>'terms.text'])->param;

    foreach (Yii::$app->session['data_step5'] as $key => $value) {
      $data[$key] = $value;
    }
    $fp = Yii::$app->session['price'] * $data['quantity'];
    Yii::$app->session['cost'] = $fp;
    return $data;
  }

  public static function getInfo($query)
  {
    if (is_numeric($query)) {
      $number = $query;
    }else{
      preg_match("/([a-zA-Z]+)([0-9]+)/", $query, $matches);
      $number = $matches[2];
    }
    $order = Order::findOne(['number' => $number]);
    if ($order) {
      return 'Статус заказа: '. \backend\helpers\OrderHelper::getStatusName($order->status);
    }
    return 'Заказ не найден';
  }


}
