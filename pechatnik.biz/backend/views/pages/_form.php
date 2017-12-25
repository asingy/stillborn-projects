<?php

use yii\helpers\Html;
use yii\redactor\widgets\Redactor;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'content')->widget(Redactor::className(), [
                'options' => [
                    'style' => 'height: 500px;',
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
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="box-footer">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
