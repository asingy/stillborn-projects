<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\helpers\ClicheTplHelper;
use backend\helpers\ClicheHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\search\StampTypesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerJs("$('.create-cliche-tpl').click(function () {
     $.ajax({
        url: '".Url::to(['/cliche-tpl/create'])."',
        type: 'GET',
        data: {'id_cliche':".$model->id."},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        },
     });
})");

$this->registerJs("$('.update').click(function () {
     $.ajax({
        url: '".Url::to(['/cliche-tpl/update'])."',
        type: 'GET',
        data: {id : $(this).data('id')},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        },
     });
})");

$this->registerJs("$('.edit-fields').click(function () {
    var field_id = $(this).data('id');
    
     $.ajax({
        url: '".Url::to(['/cliche-tpl/fields'])."',
        type: 'GET',
        data: {id : field_id},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
            $('#editor-viewport').trigger('editorReload', [{id : field_id}]);
        },
     });
})");

?>


      <?= Html::button('Создать', ['class' => 'pull-right create-cliche-tpl btn btn-flat btn-sm btn-success']); ?>


        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'tableOptions'=>['class'=>'table table-striped'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute'=>'image','format'=>'html', 'value'=>function ($model)
                    {
                      return Html::img(Url::to(Yii::$app->request->baseUrl.'/images/cliche_tpl/'.$model->image, true), ['width'=>'100px']);
                    }],
                    // 'id',
                    ['attribute'=>'id_cliche','format'=>'html', 'filter'=>ClicheHelper::getAllNames(), 'value'=>function ($model)
                    {
                      return ClicheHelper::getName($model->id_cliche);
                    }],
                    'name:ntext',
                    'info:ntext',

                    ['attribute'=>'status','format'=>'html', 'filter'=>ClicheTplHelper::getAllStats(), 'value'=>function ($model)
                    {
                      return ClicheTplHelper::getStatusLabels($model->status);
                    }],
                    // 'order',

                    ['class' => 'yii\grid\ActionColumn','template'=>'{fields} {update} {delete}','buttons'=>[
                              'fields'=>function ($url, $model) {
                                  return Html::button('<i class="fa fa-server"></i>', ['data-id'=>$model->id, 'class'=>'edit-fields btn btn-flat btn-default btn-xs']);
                              },
                              'update'=>function ($url, $model) {
                                  return Html::button('<i class="glyphicon glyphicon-edit"></i>', ['data-id'=>$model->id, 'class'=>'update btn btn-flat btn-primary btn-xs']);
                              },
                              'delete'=>function ($url, $model) {
                                  return Html::a('<i class="glyphicon glyphicon-trash"></i>',['/cliche-tpl/delete', 'id'=>$model->id],[
                                      'data' => [
                                          'confirm' => 'Точно хотите удалить?',
                                          'method' => 'post',
                                      ],'class'=>'btn btn-flat btn-danger btn-xs',
                                  ]);
                              },
                          ],'contentOptions'=>['class'=>'text-right col-md-1']],
                ],
            ]); ?>
