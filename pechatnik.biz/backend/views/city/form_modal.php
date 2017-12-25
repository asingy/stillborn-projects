<?php
use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

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
        <div class="col-md-6">
          <?= $form->field($model, 'name')->textInput() ?>
        </div>
        <div class="col-md-6">
          <?= $form->field($model, 'code')->textInput() ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <?= $form->field($model, 'delivery_price')->textInput() ?>
        </div>
        <div class="col-md-6">
          <?= $form->field($model, 'reward')->textInput() ?>
        </div>
      </div>

      <?= $form->field($model, 'cname')->textInput() ?>

    </div>
    <div class="modal-footer">
         <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-plus"></i> Создать' : '<i class="glyphicon glyphicon-edit"></i> Изменить', ['class' => 'pull-right btn-flat btn btn-primary']) ?>
    </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
