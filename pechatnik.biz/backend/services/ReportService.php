<?php

namespace backend\services;

use backend\models\ReportAgent;
use backend\models\ReportSystem;
use backend\models\Order;
use backend\helpers\ProducerHelper;
use yii\helpers\ArrayHelper;

/**
 *
 */
class ReportService
{

    public static function writeOrder(Order $model)
    {
      self::saveAgent($model);
      self::saveSystem($model);
    }

    private static function saveAgent($model)
    {
      $agentReport = new ReportAgent();
      $agentReport->order_number = $model->city->code . $model->number;
      $agentReport->date = date('Y-m-d');
      $agentReport->id_producer = $model->id_producer;
      $agentReport->cost_producer = ProducerHelper::getProducerCost($model->id_producer, $model->cliche_tpl->id_cliche, $model->id_stamp) * $model->quantity;
      $agentReport->cost_client = $model->cost;
      $agentReport->system_reward = $model->city->reward;
      $agentReport->agent_profit = $agentReport->cost_client - $agentReport->cost_producer - $agentReport->system_reward;
      $agentReport->save(false);
    }

    private static function saveSystem($model)
    {
      $systemReport = new ReportSystem();
      $systemReport->order_number = $model->city->code . $model->number;
      $systemReport->date = date('Y-m-d');
      $systemReport->id_producer = $model->id_producer;
      $systemReport->id_agent = $model->agent_producer->id_agent;
      $systemReport->system_reward = $model->city->reward;
      $systemReport->save(false);
    }


}
