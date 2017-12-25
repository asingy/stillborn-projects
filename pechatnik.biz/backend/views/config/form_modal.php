<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\helpers\ConfigHelper;

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
          <?= $form->field($model, 'name')->textInput(['disabled' => $model->isNewRecord ? false : true]) ?>
        </div>
        <div class="col-md-4">
          <?= $form->field($model, 'status')->dropDownList(ConfigHelper::getAllStats(),[]) ?>
        </div>
      </div>

      <?= $form->field($model, 'param')->textarea(['rows' => 4]) ?>

      <?= $form->field($model, 'info')->textInput() ?>

    </div>
    <div class="modal-footer">
         <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-plus"></i> Создать' : '<i class="glyphicon glyphicon-edit"></i> Изменить', ['class' => 'pull-right btn-flat btn btn-primary']) ?>
    </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
