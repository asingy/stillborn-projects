<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\helpers\ProducerHelper;
use backend\helpers\CityHelper;

/* @var $this yii\web\View */
/* @var $contact backend\models\Contacts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contacts-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
      <div class="col-md-4">
        <?= $form->field($contact, 'name')->textInput() ?>
      </div>
      <div class="col-md-4">
        <?= $form->field($contact, 'cname')->textInput() ?>
      </div>
      <div class="col-md-4">
        <?= $form->field($contact, 'email')->textInput() ?>
      </div>
    </div>


    <div class="row">
      <div class="col-md-4">
        <?= $form->field($contact, 'inn')->textInput() ?>
      </div>
      <div class="col-md-4">
        <?= $form->field($contact, 'ogrn')->textInput() ?>
      </div>
      <div class="col-md-4">
          <?= $form->field($contact, 'address')->textInput() ?>
      </div>
    </div>


    <div class="row">
      <div class="col-md-4">
        <?= $form->field($contact, 'id_city')->dropDownList(CityHelper::getAll(),['prompt'=>'-- Город --']) ?>
      </div>
      <div class="col-md-4">
        <?= $form->field($contact, 'contact_person')->textInput() ?>
      </div>
      <div class="col-md-4">
        <?= $form->field($contact, 'contact_phone')->textInput() ?>
      </div>
    </div>



    <div class="row">
      <div class="col-md-3">
          <?= $form->field($model, 'need_scan_docs')->dropDownList([1=>'Да', 0=>'Нет'],['prompt'=>'-- Нужны ? --']) ?>
      </div>
      <div class="col-md-3">
        <?= $form->field($model, 'status')->dropDownList(ProducerHelper::getAllStats(),[]) ?>
      </div>
      <div class="col-md-3">
        <?= $form->field($model, 'is_default')->dropDownList([1=>'Да', 0=>'Нет'],['prompt'=>'-- По умолчанию --']) ?>
      </div>
      <div class="col-md-3">
          <?= $form->field($contact, 'bot_phone')->textInput() ?>
      </div>
    </div>


      <?= $form->field($contact, 'info')->textInput() ?>

    <div class="box-footer">
        <?= Html::submitButton($contact->isNewRecord ? 'Создать' : 'Изменить', ['class' => $contact->isNewRecord ? 'btn btn-flat btn-success' : 'btn btn-flat btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
