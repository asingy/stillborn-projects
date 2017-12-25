<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
?>

<h3>Список пользователей в группе '<?php echo $role; ?>'</h3>
<br>
<?php echo GridView::widget([
		'dataProvider' => new ArrayDataProvider(['allModels' => \Yii::$app->authManager->getPermissionsByRole($role)]),
		// 'filterModel' => $searchModel,
		'columns' => [
			// 'type',
			'name',
			'description',
			['attribute' => 'createdAt', 'value' => function ($data) {return gmdate('d.m.Y H:i:s', $data->createdAt);}],
			['attribute' => 'updatedAt', 'value' => function ($data) {return gmdate('d.m.Y H:i:s', $data->updatedAt);}],

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>
<h3>Добавить пользователя к группе '<?php echo $role; ?>'</h3>
<br>
