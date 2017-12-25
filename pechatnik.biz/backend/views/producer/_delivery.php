<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\helpers\CityHelper;
use backend\helpers\DeliveryHelper;
/* @var $this yii\web\View */
/* @var $contact backend\models\Contacts */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs("$('.add-del').click(function () {
     $.ajax({
        url: '".Url::to(['/delivery/create'])."',
        type: 'GET',
        data: {'id': ".$model->id.", 'contact_type': ".$contact_type."},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        },
     });
    })");

    $this->registerJs("$('.update-dl').click(function () {
         $.ajax({
            url: '".Url::to(['/delivery/update'])."',
            type: 'GET',
            data: {id : $(this).data('id')},
            success: function(data) {
                $('#myModal').html(data);
                $('#myModal').modal();
            },
         });
        })");

?>


      <?= Html::button('Добавить', ['class' => 'pull-right add-del btn btn-flat btn-success']); ?>

   <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'tableOptions'=>['class'=>'table table-striped'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'id_producer',
            ['attribute'=>'id_city','format'=>'html', 'filter'=> CityHelper::getAll(), 'value'=>function ($model)
            {
              return CityHelper::getById($model->id_city);
            }],
            'address:ntext',
            ['attribute'=>'status','format'=>'html', 'filter'=>DeliveryHelper::getAllStats(), 'value'=>function ($model)
            {
              return DeliveryHelper::getStatusLabels($model->status);
            }],
            'info:ntext',

            ['class' => 'yii\grid\ActionColumn','template'=>'{update} {delete}','buttons'=>[
                      'update'=>function ($url, $model) {
                          return Html::button('<i class="glyphicon glyphicon-edit"></i>', ['data-id'=>$model->id,'class'=>'update-dl btn btn-flat btn-primary btn-xs']);
                      },
                      'delete'=>function ($url, $model) {
                          return Html::a('<i class="glyphicon glyphicon-trash"></i>',['/delivery/delete', 'id'=>$model->id],[
                              'data' => [
                                  'confirm' => 'Точно хотите удалить?',
                                  'method' => 'post',
                              ],'class'=>'btn btn-flat btn-danger btn-xs',
                          ]);
                      },
                  ],'contentOptions'=>['class'=>'text-right col-md-1']],
        ],
    ]); ?>
