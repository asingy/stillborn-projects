<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\helpers\CityHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\search\AgentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Агенты';

$this->registerJs("
$('.update-agent').on('click', function(){
  localStorage.removeItem('active-agent-tab');
});
");
?>
<div class="agents-index">

  <div class="box box-primary">
      <div class="box-header with-border">
          <h4 class="box-title"><?= Html::encode($this->title) ?></h4>
          <div class="box-tools ">
              <?= Html::a('Создать', ['create'], ['class' => 'btn btn-flat btn-sm btn-success']); ?>
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
                      // 'id_contact',
                      // 'payment_email:ntext',
                      // 'client_delivery',
                      ['attribute'=>'contact.id_city','format'=>'html', 'filter'=> CityHelper::getAll(), 'value'=>function ($model)
                      {
                        return CityHelper::getById($model->contact->id_city);
                      }],
                      'contact.name',
                      'contact.cname',
                      'contact.contact_person',
                      'contact.contact_phone',
                      // 'reward',

                      ['class' => 'yii\grid\ActionColumn','template'=>'{update}','buttons'=>[
                                'update'=>function ($url, $model) {
                                    return Html::a('<i class="glyphicon glyphicon-edit"></i>', ['update', 'id'=>$model->id], ['class'=>'update-agent btn btn-flat btn-primary btn-xs']);
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
