<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\models\Config;
use backend\helpers\ConfigHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\search\ConfigsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $type == Config::TYPE_BACKEND ? 'Конфигурация backend' : 'Конфигурация frontend';

Url::remember(Url::current(), 'url-configs');
$this->registerJs("$('.create').click(function () {
     $.ajax({
        url: '".Url::to(['create'])."',
        type: 'GET',
        data: {'type': ".$type."},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        },
     });
    })");
$this->registerJs("$('.update').click(function () {
     $.ajax({
        url: '".Url::to(['update'])."',
        type: 'GET',
        data: {id : $(this).data('id')},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        },
     });
    })");
?>
<div class="configs-index">

  <div class="box box-primary">
      <div class="box-header with-border">
          <h4 class="box-title"><?= Html::encode($this->title) ?></h4>
          <div class="box-tools ">
              <?= Html::button('Создать', ['class' => 'create btn btn-flat btn-sm btn-success']); ?>
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

                    // 'id',
                    'name:ntext',
                    'param:ntext',
                    'info:ntext',
                    ['attribute'=>'status','format'=>'html', 'filter'=>ConfigHelper::getAllStats(), 'value'=>function ($model)
                    {
                      return ConfigHelper::getStatusLabels($model->status);
                    }],
                    ['class' => 'yii\grid\ActionColumn','template'=>'{update}','buttons'=>[
                              'update'=>function ($url, $model) {
                                  return Html::button('<i class="glyphicon glyphicon-edit"></i>', ['data-id'=>$model->id, 'class'=>'update btn btn-flat btn-primary btn-xs']);
                              },
                              'delete'=>function ($url, $model) {
                                  return Html::a('<i class="glyphicon glyphicon-trash"></i>',['delete', 'id'=>$model->id],[
                                      'data' => [
                                          'confirm' => 'Точно хотите удалить?',
                                          'method' => 'post',
                                      ],'class'=>'btn btn-flat btn-danger btn-xs',
                                  ]);
                              },
                          ],'contentOptions'=>['class'=>'text-right col-md-1']],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
      </div>
    </div>
</div>
