<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\date\DatePicker;
use backend\helpers\UserHelper;
use backend\helpers\OrderHelper;

 ?>
<?php Pjax::begin(); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions'=>['class'=>'table table-striped'],
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            ['header'=>'Печать','format'=>'raw', 'headerOptions'=>['style' => 'color:#3c8dbc;'],'value'=>function ($model)
            {
                if ($model->cliche_tpl) {
                    return Html::img(Url::to(Yii::$app->request->baseUrl . '/images/cliche_tpl/' . $model->cliche_tpl->image, true), ['width' => '100px']);
                }

                return null;return Html::img(Url::to(Yii::$app->request->baseUrl.'/images/cliche_tpl/'.$model->cliche_tpl->image, true), ['width'=>'100px']);
            }],
            ['header'=>'Оснастка','format'=>'raw', 'headerOptions'=>['style' => 'color:#3c8dbc;'], 'value'=>function ($model)
            {
              return Html::img(Url::to(Yii::$app->request->baseUrl.'/images/stamp/'.$model->stamp->image, true), ['width'=>'100px']);
            }],
            // 'id',
            ['attribute'=>'date','format' =>'datetime', 'value'=>'date','filter'=>DatePicker::widget([
              'model'=>$searchModel,
              'attribute'=>'date',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'todayHighlight' => true,
                    'format' => 'dd.mm.yyyy',
                ],
              ])],
            ['attribute'=>'number', 'value'=>function ($model)
            {
              return  'VRN' . $model->number;
            }],
            ['attribute'=>'id_client','format'=>'text', 'value'=>function ($model)
            {
              return $model->client->name;
            }],
            ['attribute'=>'id_producer','format'=>'text', 'value'=>function ($model)
            {
              if ($model->id_producer == 0) {
                return 'Не определён';
              }
              return $model->producer->contact->name;
            }],
            // 'id_stamp',
            // 'id_client',
            // 'id_producer',

            // 'id_delivery',
            // 'id_payment',
            'quantity',
            'cost',
            // 'stamp_inn',
            // 'stamp_ogrn:ntext',
            // 'stamp_org_name:ntext',
            // 'stamp_org_address:ntext',
            ['attribute'=>'status','format'=>'html', 'filter'=>OrderHelper::getAllStats(), 'value'=>function ($model)
            {
              return OrderHelper::getStatusLabels($model->status);
            }],
            ['attribute'=>'id_user', 'filter'=>UserHelper::getAllUsers(), 'value'=>function ($model)
            {
              if ($model->id_user == 0) {
                return 'Сайт';
              }
              return $model->user->description;
            }],
            // 'payment_status',

            // 'date_done',
            // 'delivery_address:ntext',

            ['class' => 'yii\grid\ActionColumn','template'=>'{update} {delete}','buttons'=>[
                      'update'=>function ($url, $model) {
                          return Html::a('<i class="glyphicon glyphicon-edit"></i>', ['/order/update', 'id'=>$model->id], ['class'=>'update btn btn-flat btn-primary btn-xs']);
                      },
                      'delete'=>function ($url, $model) {
                          return Html::a('<i class="glyphicon glyphicon-trash"></i>',['/order/delete', 'id'=>$model->id],[
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
