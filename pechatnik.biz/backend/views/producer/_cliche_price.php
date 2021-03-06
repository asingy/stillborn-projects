<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\helpers\ClicheHelper;
use backend\helpers\ProducerHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\search\PriceStampsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Цены на печати';

$this->registerJs("$('.create').click(function () {
     $.ajax({
        url: '".Url::to(['/producer-cliche-price/create'])."',
        type: 'GET',
        data: {'id_producer': ".$model->id."},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        },
     });
    })");
$this->registerJs("$('.update').click(function () {
     $.ajax({
        url: '".Url::to(['/producer-cliche-price/update'])."',
        type: 'GET',
        data: {id : $(this).data('id')},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        },
     });
    })");
?>
<?= Html::button('Создать', ['class' => 'pull-right create btn btn-flat btn-success']); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'tableOptions'=>['class'=>'table table-striped'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'id',
                // 'id_stamp_type',
                ['attribute'=>'cliche.image','format'=>'html', 'headerOptions'=>['style'=>'color: #3c8dbc;'],'value'=>function ($model)
                {
                  return Html::img(Url::to(Yii::$app->request->baseUrl.'/images/cliche/'.$model->cliche->image, true), ['width'=>'100px']);
                }],
                ['attribute'=>'id_cliche','format'=>'html', 'filter'=> ClicheHelper::getAllNames(), 'value'=>function ($model)
                {
                  return ClicheHelper::getName($model->id_cliche);
                }],

                ['attribute'=>'id_cliche_size', 'value'=>function ($model)
                {
                  if ($model->cliche_size) {
                    return $model->cliche_size->size;
                  }
                  return '';
                }],
                'price',
                ['attribute'=>'status','format'=>'html', 'filter'=>ProducerHelper::getAllStats(), 'value'=>function ($model)
                {
                  return ProducerHelper::getStatusLabels($model->status);
                }],
                // 'status',
                // 'info:ntext',

                ['class' => 'yii\grid\ActionColumn','template'=>'{update} {delete}','buttons'=>[
                          'update'=>function ($url, $model) {
                              return Html::button('<i class="glyphicon glyphicon-edit"></i>', ['data-id'=>$model->id, 'class'=>'update btn btn-flat btn-primary btn-xs']);
                          },
                          'delete'=>function ($url, $model) {
                              return Html::a('<i class="glyphicon glyphicon-trash"></i>',['/producer-cliche-price/delete', 'id'=>$model->id],[
                                  'data' => [
                                      'confirm' => 'Точно хотите удалить?',
                                      'method' => 'post',
                                  ],'class'=>'btn btn-flat btn-danger btn-xs',
                              ]);
                          },
                      ],'contentOptions'=>['class'=>'text-right col-md-1']],
            ],
        ]); ?>
