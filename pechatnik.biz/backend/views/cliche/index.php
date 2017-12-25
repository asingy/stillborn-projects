<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\helpers\ClicheHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\search\ClicheSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Печати';

$this->registerJs("$('.create').click(function () {
     $.ajax({
        url: '".Url::to(['create'])."',
        type: 'GET',
        data: {},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        },
     });
    })");

$this->registerJs("$('.update').click(function () {
     $.ajax({
        url: '".Url::to(['update'])."',
        type: 'GET',
        data: {id : $(this).data('id')},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        },
     });
    })");

$this->registerJs("
$('.update-cliche').on('click', function(){
  localStorage.removeItem('active-cliche-tab');
});
");

?>
<div class="stamp-types-index">
  <div class="box box-primary">
      <div class="box-header with-border">
          <h4 class="box-title"><?= Html::encode($this->title) ?></h4>
          <div class="box-tools ">
              <?= Html::button('Создать', ['class' => 'create btn btn-flat btn-sm btn-success']); ?>
          </div>
      </div>
      <div class="box-body table-responsive no-padding">

        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions'=>['class'=>'table table-striped'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute'=>'image','format'=>'html', 'value'=>function ($model)
                    {
                      return Html::img(Url::to(Yii::$app->request->baseUrl.'/images/cliche/'.$model->image, true), ['width'=>'100px']);
                    }],
                    // 'id',
                    'name:ntext',
                    'info:ntext',

                    ['attribute'=>'status','format'=>'html', 'filter'=>ClicheHelper::getAllStats(), 'value'=>function ($model)
                    {
                      return ClicheHelper::getStatusLabels($model->status);
                    }],
                    // 'order',

                    ['class' => 'yii\grid\ActionColumn','template'=>'{update}','buttons'=>[
                              'update'=>function ($url, $model) {
                                  return Html::a('<i class="glyphicon glyphicon-edit"></i>', ['update', 'id'=>$model->id],['data-id'=>$model->id, 'class'=>'update-cliche btn btn-flat btn-primary btn-xs']);
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

      </div>
    </div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title">Инструкция</h4>
        </div>
        <div class="box-body table-responsive no-padding">
            <div class="notify">
                <ul class="list-group">
                    <li class="list-group-item">Редактор предназначен только для печатей с закругленным текстом и только на три копии одного поля</li>
                    <li class="list-group-item">Если в SVG нет нужного id-атрибута - открыть в блокноте и добавить</li>
                    <li class="list-group-item">Переопределение по размеру действует на все макеты одной печати, что подходит под штампы, а для других печатей нет необходимости.</li>
                    <li class="list-group-item">При необходимости поставить текст по центру - использовать атрибут text-anchor="middle"</li>
                    <li class="list-group-item">Для того чтобы работало заполнение обычного текста в макете необходимо соответствовать id-атрибутам ниже в таблице:</li>
                </ul>
                <table class="table table-striped">
                    <thead>
                    <tr style="font-weight: bold">
                        <td>Поле</td>
                        <td>ID</td>
                    </tr>
                    </thead>
                    <tr>
                        <td>ОГРН ООО, ОГРН ИП</td>
                        <td>cliche_orgn</td>
                    </tr>
                    <tr>
                        <td>Город</td>
                        <td>cliche_city</td>
                    </tr>
                    <tr>
                        <td>Текст</td>
                        <td>cliche_text</td>
                    </tr>
                    <tr>
                        <td>Название</td>
                        <td>cliche_name, cliche_name2</td>
                    </tr>
                    <tr>
                        <td>ФИО</td>
                        <td>cliche_surname (фамилия), cliche_name (имя), cliche_middlename (отчество)</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
