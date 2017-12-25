<?php
use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

$this->registerJs(
        '$("document").ready(function(){
            $("#sizes_form").on("pjax:end", function() {
            $.pjax.reload({container:"#sizes-list"});  //Reload GridView
        });
    });'
    );

?>
<?php Pjax::begin(['id' => 'sizes_form']) ?>
<?php $form = ActiveForm::begin(['id'=>'stamp-types-form','enableAjaxValidation' => true, 'validateOnSubmit' => false, 'options'=>['enctype'=>'multipart/form-data']]); ?>
<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">
        <?= $model->isNewRecord ? 'Создать' : 'Изменить' ?>
      </h4>
    </div>
    <div class="modal-body">

            <?= $form->field($model, 'size')->textInput(['maxlength' => 128]) ?>
    </div>
    <div class="modal-footer">
        <?= $model->isNewRecord ? '' : Html::a('<i class="glyphicon glyphicon-trash"></i> Удалить', ['delete_size', 'id'=>$model->id], ['class' => 'pull-left btn-flat btn btn-danger',
        'data' => [
            'confirm' => 'Точно хотите удалить?',
            'method' => 'post',
        ],
        ]) ?>

         <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-plus"></i> Создать' : '<i class="glyphicon glyphicon-edit"></i> Изменить', ['class' => 'pull-right btn-flat btn btn-primary']) ?>
    </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
 <?php Pjax::end(); ?>
