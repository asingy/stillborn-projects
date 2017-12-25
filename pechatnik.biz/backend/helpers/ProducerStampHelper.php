<?php

namespace backend\helpers;

use Yii;
use backend\models\ProducerStamp;
use backend\models\StampPrice;
use yii\helpers\ArrayHelper;
class ProducerStampHelper
{

  public static function checkStamp(StampPrice $model)
  {
    $ps = ProducerStamp::findAll(['id_stamp' => $model->id_stamp]);
    if ($ps) {
      foreach ($ps as $key => $value) {
        if ($model->price < $value->price) {
          return false;
        }
      }
      return true;
    }
    return false;
  }

}
