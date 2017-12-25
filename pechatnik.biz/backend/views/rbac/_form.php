<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use kartik\widgets\Select2;

?>
<?php ActiveForm::begin(); ?>
<div class="box">
    <div class="box-header" style="padding:10px">
            <h4 class="pull-left"><?= Html::encode($this->title) ?></h4>
            <div class="btn-group pull-right">
				<?= Html::submitButton($role=='' ?'Создать':'Изменить', ['class' => 'btn-flat btn btn-primary']) ?>
				 <?= $role!=='' ?
				 	Html::a('Удалить', ['delete', 'id' => $role], [
                    'class' => 'btn btn-flat btn-danger',
                    'data' => [
                        'confirm' => 'Точно хотите удалить?',
                        'method' => 'post',
                    ],
                ]) : '' ?>
			</div>
	</div>
	<div class="box-body">  
		<div class="row">
			<div class="col-md-6 form-group">
				<?= Html::label('Имя','',['class'=>'control-label'] ) ?>
				<?= Html::Input('', 'role', $role, ['class'=>'form-control']) ?>
				<?= Html::label('Описание','',['class'=>'control-label'] ) ?>
				<?= Html::Input('', 'desc', $role == ''? '':\Yii::$app->authManager->getRole($role)->description, ['class'=>'form-control']) ?>
			</div>
			<div class="col-md-6">
				<br>
				<?= Html::label('Подченённые роли','', ['class'=>'control-label']) ?>
				<br><br>
				<?= Html::checkboxList('child', empty($children)?'':$children, $roles) ?>
			</div>
		</div>
		<?php //print_r($perm); ?>
	</div>
</div>
<?php ActiveForm::end(); ?>