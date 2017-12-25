<?php

namespace backend\helpers;

use Yii;
use backend\models\ProducerClichePrice;
use backend\models\ClichePrice;
use yii\helpers\ArrayHelper;
class ProducerClichePriceHelper
{

  public static function checkCliche(ClichePrice $model)
  {
    $pcp = ProducerClichePrice::findAll(['id_cliche' => $model->id_cliche]);
    if ($pcp) {
      foreach ($pcp as $key => $value) {
        if ($model->price < $value->price) {
          return false;
        }
      }
      return true;
    }
    return false;
  }

}
