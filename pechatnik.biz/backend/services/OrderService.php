<?php

namespace backend\services;

use backend\models\ProducerClicheTpl;
use backend\models\ClicheTpl;
use backend\models\Order;
use yii\helpers\ArrayHelper;

/**
 *
 */
class OrderService
{
    public static function serializeFields($fields, $id_cliche_tpl)
    {
      $array = [];
      $tpl_fields = ClicheTpl::findOne($id_cliche_tpl);
      foreach (json_decode($tpl_fields->fields) as $key => $value) {
          $array[] = ['field'=> $value->field, 'name'=> $value->name, 'val' =>$fields[$value->field]];
      }
      return json_encode($array);
    }
}
