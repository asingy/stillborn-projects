<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\helpers\ClientHelper;
use backend\helpers\CityHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\search\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Клиенты';

Url::remember(Url::current(), 'url-client');

$this->registerJs("$('.create').click(function () {
     $.ajax({
        url: '".Url::to(['create'])."',
        type: 'GET',
        data: {},
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
<div class="clients-index">

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
                      'name',

                      ['attribute'=>'id_city','format'=>'html', 'filter'=> CityHelper::getAll(), 'value'=>function ($model)
                      {
                        return CityHelper::getById($model->id_city);
                      }],
                      'address:ntext',

                      ['attribute'=>'phone', 'value'=>function ($model)
                      {
                        return '+7 '. $model->phone;
                      }],
                      // 'info:ntext',
                      ['attribute'=>'status','format'=>'html', 'filter'=>ClientHelper::getAllStats(), 'value'=>function ($model)
                      {
                        return ClientHelper::getStatusLabels($model->status);
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
