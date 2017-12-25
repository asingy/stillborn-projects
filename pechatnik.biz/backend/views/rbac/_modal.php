<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Clients */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['id'=>'delivery-put','enableAjaxValidation' => true, 'validateOnSubmit' => true]); ?>
<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">
        <?= $role === '' ? 'Создать' : 'Изменить' ?> 
      </h4>
    </div>
    <div class="modal-body">
      <?= Html::label('Имя','',[] ) ?>
      <?= Html::Input('', 'role', $role, ['class'=>'form-control form-group']) ?>
      <?= Html::label('Описание','',['class'=>'control-label'] ) ?>
      <?= Html::Input('', 'desc', $role == ''? '':\Yii::$app->authManager->getRole($role)->description, ['class'=>'form-control form-group']) ?>
      <?= Html::label('Подченённые роли','', ['class'=>'control-label']) ?>
      <?= Html::checkboxList('child', empty($children)?'':$children, $roles) ?>     
    </div>
    <div class="modal-footer">
         <?= Html::submitButton($role === '' ? '<i class="glyphicon glyphicon-plus"></i> Создать' : '<i class="glyphicon glyphicon-edit"></i> Изменить', ['class' => 'btn-flat btn btn-primary']) ?>
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
</div>

<?php ActiveForm::end(); ?>