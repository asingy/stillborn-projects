<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\helpers\StampHelper;
use backend\helpers\CityHelper;

$this->registerJS("
$('#stamp_choise').on('change',function(){
  var id_stamp = $('#stamp_choise').val();
  $.ajax({
     url: '".Url::to(['/stamp/get_image'])."',
     type: 'GET',
     data: {'id_stamp' :id_stamp},
     success: function(data) {
         $('#stamp_image').html(data);
     },
  });
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
        <div class="col-md-6">
          <div id="stamp_image" class="thumbnail" style="padding:20px; height:180px; border-radius: 0px;margin-top: 25px;">
              <?= isset($model->stamp->image) ? Html::img(Url::to(Yii::$app->request->baseUrl.'/images/stamp/'.$model->stamp->image, true), ['style'=>'max-width: 100%;max-height: 100%;']) : '' ?>
          </div>
        </div>
        <div class="col-md-6">
          <?= $form->field($model, 'id_stamp')->dropDownList(StampHelper::getAllNames(),['id' => 'stamp_choise','prompt'=>'-- Оснастка --']) ?>

          <?= $form->field($model, 'id_city')->dropDownList(CityHelper::getAll(),['prompt'=>'-- Город --']) ?>

          <?= $form->field($model, 'price')->textInput() ?>
        </div>
      </div>



    </div>
    <div class="modal-footer">
         <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-plus"></i> Создать' : '<i class="glyphicon glyphicon-edit"></i> Изменить', ['class' => 'pull-right btn-flat btn btn-primary']) ?>
    </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
