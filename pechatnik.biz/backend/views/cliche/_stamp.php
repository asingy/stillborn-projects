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

$this->registerJs("$('.add-stc').on('click',function () {
     $.ajax({
        url: '".Url::to(['/cliche-stamp/create'])."',
        type: 'GET',
        data: {'id':".$model->id."},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        },
     });
    })");
    $this->registerJs("$('.cliche_size_stamp').on('click',function () {
          var id_cliche_stamp = $(this).data('id_cliche_stamp');
         $.ajax({
            url: '".Url::to(['/cliche-stamp/show_sizes'])."',
            type: 'GET',
            data: {'id_cliche':".$model->id.", 'id_cliche_stamp' : id_cliche_stamp},
            success: function(data) {
                $('#myModal').html(data);
                $('#myModal').modal();
            },
         });
        })");

?>


      <?= Html::button('Добавить', ['class' => 'pull-right add-stc btn btn-flat btn-sm btn-success']); ?>

    <div id="stamp-cases-id">
      <?php $pjax = Pjax::begin(['id'=>'stamp-cases']); ?>
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
                    ['attribute'=>'cliche_size_stamp.id_cliche_size', 'format'=>'html', 'value'=>function ($model)
                    {
                      if($model->cliche_size_stamp){
                        $str = '';
                        foreach ($model->cliche_size_stamp as $key => $value) {
                          if ($value->id_cliche_stamp == $model->id) {
                            if ($key == 0) {
                              $str .= $value->cliche_size->size;
                            } else {
                              $str .= ', ' . $value->cliche_size->size;
                            }
                          }
                        }
                        return $str;
                      }
                      return '<span class="text-danger">Размеры не определены</span>';
                    }],

                    'stamp.info:ntext',
                    // ['attribute'=>'stamp_cases.id_stamp_type','format'=>'html', 'filter'=>StampTypesHelper::getAllNames(), 'value'=>function ($model)
                    // {
                    //   return StampTypesHelper::getName($model->stamp_cases->id_stamp_type);
                    // }],
                    ['attribute'=>'stamp.status','format'=>'html', 'filter'=>StampHelper::getAllStats(), 'value'=>function ($model)
                    {
                      return StampHelper::getStatusLabels($model->stamp->status);
                    }],
                    // 'order',

                    ['class' => 'yii\grid\ActionColumn','template'=>'{add_size} {delete}','buttons'=>[
                              'update'=>function ($url, $model) {
                                  return Html::button('<i class="glyphicon glyphicon-edit"></i>', ['data-id'=>$model->id, 'class'=>'update btn btn-flat btn-primary btn-xs']);
                              },
                              'add_size'=>function ($url, $model) {
                                  return Html::button('<i class="fa fa-arrows"></i>', ['data-id_cliche_stamp'=>$model->id, 'class'=>'cliche_size_stamp btn btn-flat btn-default btn-xs']);
                              },
                              'delete'=>function ($url, $model) {
                                  return Html::a('<i class="glyphicon glyphicon-trash"></i>',['/cliche-stamp/delete', 'id'=>$model->id],[
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
