<?php

namespace backend\services;

use backend\models\ProducerClicheTpl;
use backend\models\ProducerStamp;
use yii\helpers\ArrayHelper;

/**
 *
 */
class ProducerService
{

  public static function getTpl($id_producer, $id_cliche)
  {
    $templates = '';
    $producerClicheTpl = ProducerClicheTpl::find()->where(['id_producer' => $id_producer])->all();

    foreach ($producerClicheTpl as $value) {
      if ($value->cliche_tpl->id_cliche == $id_cliche) {
        $templates .= '<option value="'.$value->cliche_tpl->id.'">'.$value->cliche_tpl->name.'</option>';
      }
    }

    $stamps='';
    $producerStamp = ProducerStamp::find()->where(['id_producer' => $id_producer])->all();

    foreach ($producerStamp as $ps) {
      if ($ps->clihe_stamp->id_cliche == $id_cliche) {
        $stamps .= '<option value="'.$ps->stamp->id.'">'.$case->stamp->name.'</option>';
      }
    }

    return json_encode(['tpl'=>$templates, 'stamp' => $stamps]);
  }

}
