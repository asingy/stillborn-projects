<?php
use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

$this->registerJs('$("#image-up-tpl").fileinput({
        language: "ru",
        browseClass: "btn btn-flat btn-primary",
        uploadAsync: false,
        showPreview: true,
        showCaption: false,
        showUpload: false, // hide upload button
        showRemove: false, // hide remove button
        showClose: true,
        maxFileCount: 1,
        browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
        allowedFileExtensions: ["svg"]
    }).on("fileloaded", function(event, file, previewId, index, reader) {
        $(".thumbnail").hide();
          $(".text-warning").hide();
          $(".file-actions").hide();
          $(".fileinput-remove").show();
    }).on("filecleared", function(event) {
        $(".thumbnail").show();
        $(".fileinput-remove").hide();
    })');
?>
<style>
    .fileinput-remove{
        display:none;
    }
</style>

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

        <div class="row">
        <div class="col-md-6" >
            <label for="image-up">Изображение</label>
            <div class="thumbnail" style="padding:20px; height:180px; border-radius: 0px;">

                <?= isset($model->image) ? Html::img(Url::to(Yii::$app->request->baseUrl.'/images/cliche_tpl/'.$model->image, true), ['style'=>'max-width: 100%;max-height: 100%;']) : '' ?>
            </div>
            <input id="image-up-tpl" name="image" type="file" accept="image/*" class="file-loading">
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'size')->textInput(['maxlength' => 128]) ?>
        </div>
        </div>
    </div>
    <div class="modal-footer btn-group">
        <?= $model->isNewRecord ? '' : Html::a('<i class="glyphicon glyphicon-trash"></i> Удалить', ['/cliche-size/delete', 'id'=>$model->id], ['class' => 'pull-left btn-flat btn btn-danger',
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
