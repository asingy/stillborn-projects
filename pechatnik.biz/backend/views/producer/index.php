<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\helpers\CityHelper;
use backend\helpers\ProducerHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\search\ProducersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Изготовители';

$this->registerJs("
$('.update-producer').on('click', function(){
  localStorage.removeItem('active-producer-tab');
});
");
?>
<div class="producers-index">

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
                    // 'urgency',
                    // 'contacts.id_city',
                    ['attribute'=>'contact.id_city','format'=>'html', 'filter'=> CityHelper::getAll(), 'value'=>function ($model)
                    {
                      return CityHelper::getById($model->contact->id_city);
                    }],
                    'contact.name',
                    'contact.cname',
                    'contact.contact_person',
                    'contact.contact_phone',
                    ['attribute'=>'status','format'=>'html', 'filter'=>ProducerHelper::getAllStats(), 'value'=>function ($model)
                    {
                      return ProducerHelper::getStatusLabels($model->status);
                    }],
                    ['attribute'=>'is_default','format'=>'html', 'contentOptions'=>['class'=>'text-center'], 'value'=>function ($model)
                    {
                      return $model->is_default == 1 ? '<i class="text-olive fa fa-lg fa-check-circle"></i>': '';
                    }],
                    // 'need_scan_docs',
                    // 'is_default',

                    ['class' => 'yii\grid\ActionColumn','template'=>'{update}','buttons'=>[
                              'update'=>function ($url, $model) {
                                  return Html::a('<i class="glyphicon glyphicon-edit"></i>', ['update', 'id'=>$model->id], ['class'=>'update-producer btn btn-flat btn-primary btn-xs']);
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
