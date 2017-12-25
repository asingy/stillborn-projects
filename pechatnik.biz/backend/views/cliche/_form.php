<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\helpers\ClicheHelper;
use backend\models\Cliche;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model backend\models\StampTypes */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs('$("#image-up-stamp-types").fileinput({
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
<div class="stamp-types-form">

    <?php $form = ActiveForm::begin(['id'=>'stamp-types-form','enableAjaxValidation' => true, 'validateOnSubmit' => false, 'options'=>['enctype'=>'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-6" >
            <label for="image-up">Изображение</label>
            <div class="thumbnail" style="padding:20px; height:180px; border-radius: 0px;">

                <?= isset($model->image) ? Html::img(Url::to(Yii::$app->request->baseUrl.'/images/cliche/'.$model->image, true), ['style'=>'max-width: 100%;max-height: 100%;']) : '' ?>
            </div>
            <input id="image-up-stamp-types" name="image" type="file" accept="image/*" class="file-loading">
        </div>
        <div class="col-md-6">

          <div class="row">
            <div class="col-md-6">
              <?= $form->field($model, 'name')->textInput(['maxlength' => 128]) ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model, 'status')->dropDownList(ClicheHelper::getAllStats()) ?>
            </div>
          </div>

          <?= $form->field($model, 'info')->textarea(['rows' => 4]) ?>
        </div>
    </div>
    <br>

    <?= $this->render('_sizes', ['model' => $model, 'dataProvider'=>$dataProvider]) ?>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-flat btn-success' : 'btn btn-flat btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
