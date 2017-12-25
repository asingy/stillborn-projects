<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\User;
use backend\helpers\UserHelper;
use yii\helpers\ArrayHelper;
use backend\helpers\CityHelper;
?>

<?php $form = ActiveForm::begin(['id'=>'user-form','enableAjaxValidation' => true, 'validateOnSubmit' => true]); ?>
<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">
        <?= $model->isNewRecord ? 'Создать' : 'Изменить' ?>
      </h4>
    </div>
    <div class="modal-body">

      <div class="row">
        <div class="col-md-6">
          <?= $form->field($model, 'username')->textInput(['maxlength' => 64]) ?>
        </div>
        <div class="col-md-6">
          <?= $form->field($model, 'description')->textInput(['maxlength' => 128]) ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <?= $form->field($model, 'email')->textInput(['maxlength' => 128, 'type' => 'email']) ?>
        </div>
        <div class="col-md-6">
          <?= $form->field($model, 'id_city')->dropDownList(CityHelper::getAll(),['prompt'=>'-- Город --']) ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <?= $form->field($model, 'password')->passwordInput(['maxlength' => 128])  ?>
        </div>
        <div class="col-md-6">
          <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 128]) ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <?= $form->field($model, 'role')->dropDownList(['agent'=>'Агент', 'admin'=>'Администратор'], ['prompt'=>'-- Роль --']) ?>
        </div>
        <div class="col-md-6">
          <?= $form->field($model, 'status')->dropDownList(UserHelper::getAllStats(), ['prompt'=>'-- Статус --']) ?>
        </div>
      </div>
    </div>
    <div class="modal-footer">
         <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-plus"></i> Создать' : '<i class="glyphicon glyphicon-edit"></i> Изменить', ['class' => 'pull-right btn-flat btn btn-primary']) ?>
    </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
