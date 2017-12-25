<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\search\DeliverysSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пункты выдачи';

?>
<div class="deliverys-index">

  <div class="box box-primary">
      <div class="box-header with-border">
          <h4 class="box-title"><?= Html::encode($this->title) ?></h4>
          <div class="box-tools ">
              <?= Html::a('Создать', ['#'], ['class' => 'btn btn-flat btn-sm btn-success']); ?>
          </div>
      </div>
      <div class="box-body table-responsive no-padding">
          <?php Pjax::begin(); ?>
             <?= GridView::widget([
                  'dataProvider' => $dataProvider,
                  'filterModel' => $searchModel,
                  'tableOptions'=>['class'=>'table table-striped'],
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],

                      'id',
                      'id_producer',
                      'address:ntext',
                      'status',
                      'info:ntext',

                      ['class' => 'yii\grid\ActionColumn'],
                  ],
              ]); ?>
          <?php Pjax::end(); ?>
        </div>
      </div>
</div>
