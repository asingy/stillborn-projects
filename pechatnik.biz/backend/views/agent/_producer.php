<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\helpers\CityHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\search\ProducersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerJs("$('.add-pr').click(function () {
     $.ajax({
        url: '".Url::to(['/agent-producer/create'])."',
        type: 'GET',
        data: {'id': ".$model->id."},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        },
     });
    })");

?>


      <?= Html::button('Добавить', ['class' => 'pull-right add-pr btn btn-flat btn-sm btn-success']); ?>

        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'tableOptions'=>['class'=>'table table-striped'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
                    // 'id_contact',
                    // 'urgency',
                    // 'contacts.id_city',
                    ['attribute'=>'producer.contact.id_city','format'=>'html', 'filter'=> CityHelper::getAll(), 'value'=>function ($model)
                    {
                      return CityHelper::getById($model->producer->contact->id_city);
                    }],
                    'producer.contact.name',
                    'producer.contact.cname',
                    'producer.contact.contact_person',
                    'producer.contact.contact_phone',

                    // 'need_scan_docs',
                    // 'is_default',

                    ['class' => 'yii\grid\ActionColumn','template'=>'{delete}','buttons'=>[
                              'update'=>function ($url, $model) {
                                  return Html::a('<i class="glyphicon glyphicon-edit"></i>', ['update', 'id'=>$model->id], ['class'=>'update btn btn-flat btn-primary btn-xs']);
                              },
                              'delete'=>function ($url, $model) {
                                  return Html::a('<i class="glyphicon glyphicon-trash"></i>',['/agent-producer/delete', 'id'=>$model->id],[
                                      'data' => [
                                          'confirm' => 'Точно хотите удалить?',
                                          'method' => 'post',
                                      ],'class'=>'btn btn-flat btn-danger btn-xs',
                                  ]);
                              },
                          ],'contentOptions'=>['class'=>'text-right col-md-1']],
                ],
            ]); ?>
