<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
$this->title = 'Роли пользователей';
$this->params['breadcrumbs'][] = $this->title;
Url::remember(Url::current(), 'url-rbac_index');
$this->registerJs("$('.create-role').click(function () {
     $.ajax({
        url: '".Url::to(['/rbac/create'])."',
        type: 'GET',
        data: {},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        },
     });
    })");
$this->registerJs("$('.update-role').click(function () {
     $.ajax({
        url: '".Url::to(['/rbac/update'])."',
        type: 'GET',
        data: {id : $(this).data('id')},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        },
     });
    })");
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title"><?= Html::encode($this->title) ?></h4>
        <div class="box-tools">
        	<?= Html::button('<i class="glyphicon glyphicon-plus"></i> Создать', ['class' => 'create-role pull-right btn-sm btn-flat btn btn-success']) ?>
        </div>
	</div>
	<div class="box-body table-responsive no-padding">

	<?php echo GridView::widget([
		'dataProvider' => new ArrayDataProvider(['allModels' => $roles]),
		// 'filterModel' => $searchModel,
		'tableOptions'=>['class'=>'table table-striped'],
        'summaryOptions'=>['class'=>'grid-summary'],
		'columns' => [
			// ['class' => 'yii\grid\SerialColumn'],
			// 'type',
			['label'=>'Имя','value'=>'name'],
			['label' => 'Описание', 'value'=>'description'],
			// 'name',
			// 'description',
			['label' => 'Создана', 'value' => function ($data) {return gmdate('d.m.Y H:i:s', $data->createdAt);}],
			['label' => 'Обновлена', 'value' => function ($data) {return gmdate('d.m.Y H:i:s', $data->updatedAt);}],

			['class' => 'yii\grid\ActionColumn', 'template' => '{update}','buttons'=>[
                                'update'=>function ($url, $data, $key) {
                                    return Html::button('<i class="glyphicon glyphicon-edit"></i>', ['data-id'=>$key, 'class'=>'update-role btn btn-flat btn-primary btn-xs']);
                                },
                            ],'contentOptions'=>['class'=>'text-right']],
		],
	]); ?>
	</div>
</div>
