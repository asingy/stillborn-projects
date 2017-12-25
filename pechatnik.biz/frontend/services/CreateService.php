<?php

namespace frontend\services;

use backend\helpers\PaymentHelper;
use common\events\OrderStatusEvent;
use Imagick;
use Yii;
use backend\models\ClicheTpl;
use backend\models\Stamp;
use backend\models\Config;
use backend\models\Order;
use backend\models\Client;
use backend\models\City;
use backend\models\User;
use frontend\models\Create5Form;
use frontend\helpers\ClicheHelper;
use frontend\helpers\ClicheTplHelper;
use frontend\helpers\StampHelper;
use frontend\helpers\OrderHelper;
use yii\base\Exception;

/**
 * CreateService
 */
class CreateService
{

  private  $step;
  private  $post;

  function __construct($step, $post)
  {
    $this->step = $step;
    $this->post = $post;
  }

  public function saveData($step, $post)
  {
    Yii::$app->session['step'] = $step;
    $sc = $step-1;
    if ($step == 2 || $step == 3 || $step == 5) {
      Yii::$app->session['data_step'.$sc] = $post['data'];
      if (isset($post['price'])) {
        Yii::$app->session['price'] = $post['price'];
      }
    } else {
      unset($post['_csrf-frontend']);
      if (isset($post['svg'])) {
        Yii::$app->session['svg'] = $post['svg'];

          try {
            $im = new \Imagick();
            $im->readImageBlob('<?xml version="1.0" encoding="UTF-8" standalone="no"?>' . $post['svg']);
            $im->setImageFormat("png24");

            Yii::$app->session['png'] = $im->getImageBlob();
            $im->clear();
            $im->destroy();

            unset($post['svg']);
          }
          catch (\Exception $e) {
            throw new \Exception('Error convert to PNG!');
          }
      }
      Yii::$app->session['data_step'.$sc] = $post;
    }
  }

  public function next()
  {

    $this->saveData($this->step, $this->post);

    if ($this->step == 2) {
      return ClicheTplHelper::getList($this->post['data']);
    }

    if ($this->step == 3) {
      return ClicheTplHelper::getFields($this->post['data']);
    }

    if ($this->step == 4) {
      return StampHelper::listByCliche(Yii::$app->session['data_step1']);
    }

    if ($this->step == 5) {
      return new Create5Form(Yii::$app->session['data_step5']);
    }

    if ($this->step == 6) {
      return OrderHelper::getFinalData();
    }

  }

  public static function back($step)
  {
    Yii::$app->session['step'] = $step;

    if ($step == 1) {
      return ClicheHelper::typesList();
    }
    if ($step == 2) {
      return ClicheTplHelper::getList(Yii::$app->session['data_step1']);
    }
    if ($step == 3) {
      return ClicheTplHelper::getFields(Yii::$app->session['data_step2']);
    }
    if ($step == 4) {
      return StampHelper::listByCliche(Yii::$app->session['data_step1']);
    }
    if ($step == 5) {
      return new Create5Form(Yii::$app->session['data_step5']);
    }

    return '';
  }

  public static function saveOrder()
  {
    $model = new Order();
    $client = new Client();
    $data = Yii::$app->session['data_step5'];
    $cf = ['name', 'phone', 'email', 'address'];
    foreach ($cf as $k => $v) {
      $client->{$v} = $data[$v];
      unset($data[$v]);
    }
    $client->id_city = City::DEFAULT_CITY_ID;
    $client->status = Client::STATUS_ACTIVE;
    if($cl = Client::find()->where(['name' => $client->name, 'phone'=>$client->phone])->one()){
      $model->id_client = $cl->id;
    }else{
      $client->save();
      $model->id_client = $client->id;
    }

    $model->number = OrderHelper::getNumber();
    $model->id_user = User::FRONTEND_USER_ID;
    $model->id_city = City::DEFAULT_CITY_ID;
    $model->id_cliche_tpl = Yii::$app->session['data_step2'];
    $model->id_cliche_size = Yii::$app->session['data_step3']['size'];
    $model->id_stamp = Yii::$app->session['data_step4'];
    $model->id_producer = OrderHelper::getProduserByAttributes($model->id_cliche_tpl, $model->id_stamp);
    $model->cliche_fields = ClicheTplHelper::fieldsSerialize(Yii::$app->session['data_step2']);
    $model->cost = Yii::$app->session['cost'];
    $model->svg = Yii::$app->session['svg'];
    $model->png = Yii::$app->session['png'];
    foreach ($data as $key => $value) {
      $model->setAttribute($key, $value);
    }

    if ($model->save()) {
      if ($model->id_payment == 2) {
        if (PaymentHelper::isPay($model->id_emoney)) {
          $model->trigger(Order::EVENT_STATUS_ORDER, new OrderStatusEvent(['model' => $model]));

          return [
              'payment' => [
                  'sum' => $model->cost,
                  'customerNumber' => $client->id,
                  'paymentType' => $model->id_emoney,
                  'cps_phone' => $client->phone,
                  'cps_email' => $client->email,
                  'orderNumber' => 'VRN' . $model->number
              ]
          ];
        }
      } else {
        $model->trigger(Order::EVENT_STATUS_NEW, new OrderStatusEvent(['model' => $model]));
        Yii::$app->session->destroy();

        return $model->number;
      }
    }

    return 'ERROR';

  }


}
