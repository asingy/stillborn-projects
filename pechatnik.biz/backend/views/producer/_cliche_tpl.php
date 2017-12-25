<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\helpers\ClicheTplHelper;
use backend\helpers\ClicheHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\search\ClicheSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerJs("$('.add-cliche').click(function () {
      var id_cliche = $('#id_cliche').val();
      if(id_cliche != ''){
       $.ajax({
          url: '".Url::to(['/producer-cliche-tpl/create'])."',
          type: 'GET',
          data: {'id':".$model->id.", 'id_cliche': id_cliche},
          success: function(data) {
              $('#myModal').html(data);
              $('#myModal').modal();
          },
       });
     }
    })");

?>


    <div class="col-md-4  pull-right">
        <div class="input-group">
          <?= Html::dropDownList('id_cliche', 'select', ClicheHelper::getAllNames(), ['id'=>'id_cliche','class' => 'form-control', 'prompt'=>'- Фильтр по печати -']); ?>
          <div class="input-group-btn">
            <?= Html::button('Добавить', ['class' => 'add-cliche btn btn-flat btn btn-success']); ?>
          </div>
        </div>
    </div>


        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'tableOptions'=>['class'=>'table table-striped'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    /*['attribute'=>'cliche_tpl.image','format'=>'html', 'value'=>function ($model)
                    {
                      return Html::img(Url::to(Yii::$app->request->baseUrl.'/images/cliche_tpl/'.$model->cliche_tpl->image, true), ['width'=>'100px']);
                    }],*/
                    // 'id',
                    /*['attribute'=>'cliche_tpl.id_cliche','format'=>'html', 'filter'=>ClicheHelper::getAllNames(), 'value'=>function ($model)
                    {
                      return ClicheHelper::getName($model->cliche_tpl->id_cliche);
                    }],*/
                    'cliche_tpl.name:ntext',
                    // 'stamp_tpl.info:ntext',

                    /*['attribute'=>'cliche_tpl.status','format'=>'html', 'filter'=>ClicheTplHelper::getAllStats(), 'value'=>function ($model)
                    {
                      return ClicheTplHelper::getStatusLabels($model->cliche_tpl->status);
                    }],*/
                    // 'order',

                    ['class' => 'yii\grid\ActionColumn','template'=>'{delete}','buttons'=>[
                              'update'=>function ($url, $model) {
                                  return Html::button('<i class="glyphicon glyphicon-edit"></i>', ['data-id'=>$model->id, 'class'=>'update btn btn-flat btn-primary btn-xs']);
                              },
                              'delete'=>function ($url, $model) {
                                  return Html::a('<i class="glyphicon glyphicon-trash"></i>',['/producer-cliche-tpl/delete', 'id'=>$model->id],[
                                      'data' => [
                                          'confirm' => 'Точно хотите удалить?',
                                          'method' => 'post',
                                      ],'class'=>'btn btn-flat btn-danger btn-xs',
                                  ]);
                              },
                          ],'contentOptions'=>['class'=>'text-right col-md-1']],
                ],
            ]); ?>
