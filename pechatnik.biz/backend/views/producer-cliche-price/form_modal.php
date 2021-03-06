<?php
use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\helpers\ClicheHelper;
use backend\helpers\ProducerHelper;

$this->registerJs("
$('#producerclicheprice-id_cliche').on('change',function(){
  var id_cliche = $(this).val();
  $.ajax({
     url: '".Url::to(['/cliche-size/get_sizes'])."',
     type: 'GET',
     data: {'id_cliche' : id_cliche},
     success: function(data) {
         $('#producerclicheprice-id_cliche_size').html(data);
     },
  });
});
");
?>

<?php $form = ActiveForm::begin(['id'=>'producer-cliche-tpl-form','enableAjaxValidation' => true, 'validateOnSubmit' => true]); ?>
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
          <?= $form->field($model, 'id_cliche')->dropDownList(ClicheHelper::getAllNames(),['prompt'=>'-- Печать --']) ?>
        </div>
        <div class="col-md-6">
          <?= $form->field($model, 'id_cliche_size')->dropDownList($stamp_sizes_list,['prompt'=>'-- Размеры --']) ?>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <?= $form->field($model, 'price')->textInput() ?>
        </div>
        <div class="col-md-6">
          <?= $form->field($model, 'status')->dropDownList(ProducerHelper::getAllStats(),[]) ?>
        </div>
      </div>

    </div>
    <div class="modal-footer">
         <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-plus"></i> Создать' : '<i class="glyphicon glyphicon-edit"></i> Изменить', ['class' => 'pull-right btn-flat btn btn-primary']) ?>
    </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
