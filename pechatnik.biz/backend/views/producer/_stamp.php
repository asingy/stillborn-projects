<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\helpers\StampHelper;
use backend\helpers\ClicheHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\search\StampTypesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerJs("$('.add-stc').on('click', function () {
     $.ajax({
        url: '".Url::to(['/producer-stamp/create'])."',
        type: 'GET',
        data: {'id':".$model->id."},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        },
     });

})");

$this->registerJs("$('.update-producer-stamp').on('click', function () {
     $.ajax({
        url: '".Url::to(['/producer-stamp/update'])."',
        type: 'GET',
        data: {id : $(this).data('id')},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        },
     });
    })");

?>



            <?= Html::button('Добавить', ['class' => 'pull-right add-stc btn btn-flat btn btn-success']); ?>


        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'tableOptions'=>['class'=>'table table-striped'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute'=>'stamp.image','format'=>'html', 'value'=>function ($model)
                    {
                      return Html::img(Url::to(Yii::$app->request->baseUrl.'/images/stamp/'.$model->stamp->image, true), ['width'=>'100px']);
                    }],
                    // 'id',
                    'stamp.name:ntext',
                    // 'stamp_cfases.info:ntext',
                    'price',
                    // ['attribute'=>'stamp_cases.id_stamp_type','format'=>'html', 'filter'=>StampTypesHelper::getAllNames(), 'value'=>function ($model)
                    // {
                    //   return StampTypesHelper::getName($model->stamp_cases->id_stamp_type);
                    // }],
                    ['attribute'=>'status','format'=>'html', 'filter'=>StampHelper::getAllStats(), 'value'=>function ($model)
                    {
                      return StampHelper::getStatusLabels($model->status);
                    }],
                    // 'order',

                    ['class' => 'yii\grid\ActionColumn','template'=>'{update} {delete}','buttons'=>[
                              'update'=>function ($url, $model) {
                                  return Html::button('<i class="glyphicon glyphicon-edit"></i>', ['data-id'=>$model->id, 'class'=>'update-producer-stamp btn btn-flat btn-primary btn-xs']);
                              },
                              'delete'=>function ($url, $model) {
                                  return Html::a('<i class="glyphicon glyphicon-trash"></i>',['/producer-stamp/delete', 'id'=>$model->id],[
                                      'data' => [
                                          'confirm' => 'Точно хотите удалить?',
                                          'method' => 'post',
                                      ],'class'=>'btn btn-flat btn-danger btn-xs',
                                  ]);
                              },
                          ],'contentOptions'=>['class'=>'text-right col-md-1']],
                ],
            ]); ?>
