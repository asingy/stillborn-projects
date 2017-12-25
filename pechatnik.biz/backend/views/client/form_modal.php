<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\helpers\ClientHelper;
use backend\helpers\CityHelper;

$phoneTpl = ["template"=>"{label}
    <div class=\"input-group\">
    <span class=\"input-group-addon\">+7</span>
    {input}
    </div>{hint}{error}"];
$this->registerJS("
$(document).ready(function(){
  $('#client-phone').inputmask({'mask': '(999) 999-9999'});
});
");
?>

<?php $form = ActiveForm::begin(['id'=>'citys-form','enableAjaxValidation' => true, 'validateOnSubmit' => true]); ?>
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
        <div class="col-md-8">
          <?= $form->field($model, 'name')->textInput() ?>
        </div>
        <div class="col-md-4">
          <?= $form->field($model, 'status')->dropDownList(ClientHelper::getAllStats(),[]) ?>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'id_city')->dropDownList(CityHelper::getAll(),[]) ?>
        </div>
        <div class="col-md-6">
                <?= $form->field($model, 'phone', $phoneTpl)->textInput() ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <?= $form->field($model, 'email')->textInput() ?>
        </div>
        <div class="col-md-6">
          <?= $form->field($model, 'address')->textInput() ?>
        </div>
      </div>


      <?= $form->field($model, 'info')->textInput() ?>

    </div>
    <div class="modal-footer">
         <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-plus"></i> Создать' : '<i class="glyphicon glyphicon-edit"></i> Изменить', ['class' => 'pull-right btn-flat btn btn-primary']) ?>
    </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
