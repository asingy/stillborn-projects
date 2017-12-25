<?php

use backend\models\Notice;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;

use backend\helpers\OrderHelper;
?>

<?php $form = ActiveForm::begin(['action' => Url::to(['notice/update', 'id'=>$model->id]), 'id'=>'citys-form-'.$model->id,'enableAjaxValidation' => true, 'validateOnSubmit' => true]); ?>
<div class="">

    <div class="">
      <div class="row">
        <div class="col-md-10">
          <?= $form->field($model, 'subj')->textInput() ?>
        </div>
        <div class="col-md-2">
          <?= $form->field($model, 'status')->dropDownList([
                  Notice::STATUS_DISABLED => 'Отключен',
                  Notice::STATUS_ENABLED => 'Включен'
              ],['prompt'=>'- Cтатус -']) ?>
        </div>
      </div>

      <?= $form->field($model, 'body')->widget(Redactor::className(), [
        'options' => [
            'id' => 'redactor-'.$model->id,
            'style' => 'height: 300px;',
        ],
        'clientOptions' => [
            'lang'              => 'ru',
            'observeLinks'      => true,
            'autoresize'        => true,
            'placeholder'       => '',
            'plugins'           => ['table', 'fontcolor', 'fontsize','imagemafixnager'],
            'buttons'           => ['html', 'formatting', 'bold', 'italic', 'deleted', 'underline', 'horizontalrule',
                                    'alignment', 'unorderedlist', 'orderedlist', 'outdent', 'indent', 'link'],
            // 'imageUpload'       => Yii::$app->urlManager->createUrl(['notice/upload']), , 'image', 'file'
            // 'fileUpload'        => Yii::$app->urlManager->createUrl(['notice/upload']),
        ],
    ]) ?>

    </div>
    <div class="box-footer">
         <?= Html::submitButton('Изменить', ['class' => 'btn-flat btn btn-primary']) ?>
    </div>

</div>

<?php ActiveForm::end(); ?>
