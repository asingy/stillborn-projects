<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\helpers\UserHelper;
use backend\helpers\CityHelper;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var auth\models\UserSearch $searchModel
 */

$this->title = 'Пользователи';

Url::remember(Url::current(), 'url-user');

$this->registerJs("$('.create-user').click(function () {
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
$this->registerJs("$('.update-user').click(function () {
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
?>
<div class="user-index">

	<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools">
           <?= Html::button('<i class="glyphicon glyphicon-plus"></i> Создать', ['class' => 'create-user btn btn-flat btn-sm btn-success']) ?>
        </div>
    </div>
    <div class="box-body table-responsive no-padding">

	<?php echo GridView::widget([
		'dataProvider' => $dataProvider,
		// 'filterModel' => $searchModel,
		'summaryOptions'=>['class'=>'grid-summary'],
		'tableOptions'=>['class'=>'table table-striped'],
		'columns' => [

      'description',
      'username',
			'email:email',
      ['attribute'=>'id_city','format'=>'html', 'filter'=> CityHelper::getAll(), 'value'=>function ($model)
      {
        return CityHelper::getById($model->id_city);
      }],
            ['attribute'=>'role', 'headerOptions'=>['style'=>'color:#3C8DBC'], 'value'=>function ($model){
                $role = Yii::$app->authManager->getRolesByUser($model->id);
                return $role[key($role)]->description;
            }],
            ['attribute' => 'status', 'format'=>'html', 'value' => function ($model) {
                return UserHelper::getStatusLabels($model->status);
              }
            ],
			['class' => 'yii\grid\ActionColumn','template'=>'{update}','buttons'=>[
                'update'=>function ($url, $model) {
                    return Html::button('<i class="glyphicon glyphicon-edit"></i>', ['data-id'=>$model->id, 'class'=>'update-user btn btn-flat btn-primary btn-xs']);
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
