<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\helpers\ProducerHelper;
use backend\helpers\AgentHelper;
use backend\helpers\ReportHelper;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\search\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Прибыль системы';
$layout = '<<< HTML
    <span class="input-group-addon" style="border-left: 1px solid #ccc;">
        &nbsp&nbsp<i class="glyphicon glyphicon-calendar"></i>&nbsp&nbsp
    </span>
    {input1}
    {separator}
    {input2}
    <span class="input-group-addon kv-date-remove" style="border-right: 0px solid #ccc;">
        &nbsp&nbsp<i class="glyphicon glyphicon-remove"></i>&nbsp&nbsp
    </span>
HTML';
?>
<div class="report-system-index">

  <div class="box box-primary">
      <div class="box-header with-border">
          <h4 class="box-title"><?= Html::encode($this->title) ?></h4>
          <div class="box-tools" style="width:330px">
            <?php  ActiveForm::begin(['method'=>'get','action'=>'system']); ?>
            <div class="input-group-btn" style="width:100px">
            <?= DatePicker::widget([
                    'model'=>$searchModel,
                    'attribute'=>'date_from',
                    'attribute2'=>'date_to',
                    'options' => ['style' => 'border-radius: 0px; width:100px'],
                    'options2' => ['style' => 'border-radius: 0px; width:100px'],
                    'type' => DatePicker::TYPE_RANGE,
                    'separator' =>'-',
                    'layout' => $layout,
                    'pluginOptions' => [
                        'format' => 'dd.mm.yyyy',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ]);
            ?>
            </div>

            <div class="input-group-btn" style="width:100%">
            <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i>', ['class' => 'btn btn-primary btn-flat']); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
      </div>
      <div class="box-body table-responsive no-padding">
        <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'showFooter'=>true,
                'tableOptions'=>['class'=>'table table-striped'],
                'footerRowOptions'=>['style'=>'font-weight:bold'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    // 'id',
                    'order_number',
                    ['attribute'=>'date', 'format'=>'date', 'value'=>'date','filter'=>DatePicker::widget([
                      'model'=>$searchModel,
                      'attribute'=>'date',
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'todayHighlight' => true,
                            'format' => 'dd.mm.yyyy',
                        ],
                      ])],
                    ['attribute'=>'id_producer', 'filter'=>ProducerHelper::getAllNames(),'value'=>'producer.contact.name'],
                    ['attribute'=>'id_agent', 'filter'=>AgentHelper::getAllNames(),'value'=>'agent_producer.agent.contact.name'],
                    ['attribute'=>'system_reward','value'=>'system_reward', 'footer'=>ReportHelper::getPageTotal($dataProvider->models,'system_reward')],
                    // 'status',

                    // ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
      </div>
    </div>
  </div>
