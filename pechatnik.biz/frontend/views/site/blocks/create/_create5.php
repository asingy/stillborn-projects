<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use frontend\helpers\OrderHelper;
use backend\helpers\PaymentHelper;
use frontend\helpers\DeliveryHelper;
use kartik\file\FileInput;
use yii\helpers\Url;

$this->registerJs("
$('#order_payment').on('change',function(){
    var payment = $(this).val();
    if(payment == 1){
      setValidate();
      $('#emoney-payment_block').addClass('hidden');
      $('#order-payment_block').removeClass('hidden');
    }else if(payment == 2){
        $('#order-payment_block').addClass('hidden');
        $('#emoney-payment_block').removeClass('hidden');
    }else{
      unsetValidate();
      $('#order-payment_block').addClass('hidden');
      $('#emoney-payment_block').addClass('hidden');
    }
});

function setValidate(){
  $('input[name=\"payment_inn\"]').addClass('bevalidate');
  $('input[name=\"payment_person\"]').addClass('bevalidate');
  $('input[name=\"payment_address\"]').addClass('bevalidate');
}

function unsetValidate(){
  $('input[name=\"payment_inn\"]').removeClass('bevalidate');
  $('input[name=\"payment_person\"]').removeClass('bevalidate');
  $('input[name=\"payment_address\"]').removeClass('bevalidate');
}
");

$this->registerJS("
  $('#id_delivery').on('change',function(e){
    $.ajax({
       url: 'get_delivery',
       type: 'GET',
       data: {'id_delivery': $(this).val()},
       success: function(data) {
           $('#delivery').html(data);
       },
    });
    e.preventDefault();
  });
function Total(){
  var q = parseInt($('select[name=\"quantity\"]').val(), 10);
  var p = parseInt(".Yii::$app->session['price'].", 10);
  $('.header-price').text(p*q);
}
$(document).ready(function(){
  $('#input-phone').inputmask({'mask': '(999) 999-9999'});
  Total();
});

$('select[name=\"quantity\"]').on('change', function(){
  Total();
});
");

$this->registerJS("
$('#w0').on('fileloaded', function(event, file, previewId, index, reader) {
       $('#w0').fileinput('upload');
       $('.kv-upload-progress').text('');
    });
");

 ?>

<div id="create5" >
  <div class="container">
    <div class="row">
      <div class="row">
        <div class="create-title section-title title-black text-center col-xs-12">
          <h1>ЗАКАЗАТЬ ПЕЧАТЬ</h1>
          <h3>5. Детали заказа</h3>
        </div>
      </div>

      <div class="row" style="margin: 0 20px;padding:30px; background-color:white;border: 2px solid #adabab;">
      <?php $form = ActiveForm::begin(['id'=>'form-step5','options'=>['enctype'=>'multipart/form-data'], 'enableAjaxValidation' => false, 'enableClientValidation' => false]); ?>
        <div class="col-md-6 text-center">
            <div class="decorate-input">
              <?= Html::textInput('name', $data['name'], ['class' => 'bevalidate constructor-input', 'type'=>'text', 'placeholder'=> 'ФИО / Наименование организации']); ?>
            </div>
            <div class="decorate-input">
              <?= Html::textInput('address', $data['address'], ['class' => 'bevalidate constructor-input', 'type'=>'text', 'placeholder'=> 'Адрес']); ?>
            </div>
            <div class="input-group">
              <span class="input-group-addon">+7</span>
              <?= Html::textInput('phone', $data['phone'], ['id'=>'input-phone','class' => 'bevalidate constructor-input', 'type'=>'tel', 'placeholder'=> 'Телефон', 'style'=>'border-left: 0;']); ?>
            </div>
            <div class="decorate-input">
              <?= Html::textInput('email', $data['email'], ['class' => 'bevalidate constructor-input', 'type'=>'email', 'placeholder'=> 'Email']); ?>
            </div>
        </div>
        <div class="col-md-6 text-center">

          <div class="decorate-input">
            <?= Html::dropDownList('quantity', $data['quantity'], [1 => '1 шт.', 2 =>'2 шт.', 3 =>'3 шт.'], ['class' => 'form-control constructor-select', 'required'=>'required']); ?>
            <i class="zmdi zmdi-chevron-down"></i>
          </div>


            <div class="decorate-input">
              <?= Html::dropDownList('id_delivery', $data['id_delivery'], DeliveryHelper::getAllTypes(), ['id'=>'id_delivery', 'class' => 'form-control constructor-select', 'required'=>'required']); ?>
              <i class="zmdi zmdi-chevron-down"></i>
            </div>
            <div id="delivery" class="decorate-input">
              <?php if (isset($data['id_delivery']) && $data['id_delivery'] == 1): ?>
                <?= Html::textInput('delivery_address', $data['delivery_address'], ['class' => 'constructor-input', 'placeholder'=> 'Адрес']) ?>
              <?php elseif(isset($data['id_delivery']) && $data['id_delivery'] == 2):?>
                <?= Html::dropDownList('delivery_address', $data['delivery_address'], DeliveryHelper::getList(), ['class' => 'form-control constructor-select', 'required'=>'required']) ?>
                <i class="zmdi zmdi-chevron-down"></i>
              <?php else: ?>
                <?= Html::textInput('delivery_address', $data['delivery_address'], ['id'=>'delivery_address','class' => 'bevalidate constructor-input', 'placeholder'=> 'Адрес']) ?>
              <?php endif; ?>

            </div>

            <div class="decorate-input">
              <?= Html::dropDownList('id_payment', $data['id_payment'], PaymentHelper::getAllNames(), ['id'=>'order_payment','class' => 'bevalidate form-control constructor-select', 'prompt'=>'- Способ оплаты -', 'required'=>'required']) ?>
              <i class="zmdi zmdi-chevron-down"></i>
            </div>
        </div>

        <div id="emoney-payment_block" class=" <?= $data->id_payment == 2 ? '' : 'hidden'?>">
          <div class="col-md-6">

          </div>
          <div class="col-md-6">
            <div class="decorate-input">
              <?= Html::dropDownList('id_emoney', $data['id_emoney'], PaymentHelper::getMethods(), ['class' => 'form-control constructor-select']) ?>
              <i class="zmdi zmdi-chevron-down"></i>
            </div>
          </div>

        </div>

        <div id="order-payment_block" class=" <?= $data->id_payment == 1 ? '' : 'hidden'?>">
          <div class="col-md-4">
            <div class="decorate-input">
              <?= Html::textInput('payment_inn', $data['payment_inn'], ['class' => 'constructor-input',  'placeholder'=> 'ИНН плательщика']); ?>
            </div>
          </div>
          <div class="col-md-3">
            <div class="decorate-input">
              <?= Html::textInput('payment_person', $data['payment_person'], ['class' => 'constructor-input',  'placeholder'=> 'Плательщик']); ?>
            </div>
          </div>
          <div class="col-md-5">
            <div class="decorate-input">
              <?= Html::textInput('payment_address', $data['payment_address'], ['class' => 'constructor-input',  'placeholder'=> 'Адрес плательщика']); ?>
            </div>
          </div>
        </div>

        <div id="scan_block" class="">
          <div class="col-md-12">
              <?= FileInput::widget([
                  'name' => 'scansFile',
                  'language' => 'ru',
                  'options' => ['multiple' => false],
                  'pluginOptions' => [
                    'showCaption' => false,
                    'showUpload' => false,
                    'showRemove' => false,
                    'showBrowse' => false,
                    'previewClass' => 'file-preview-5',
                    'browseOnZoneClick' => true,
                    'dropZoneTitle' => 'Перетащите сюда сканы документов',
                    'fileActionSettings' => ['showUpload'=>false, 'showZoom'=>false],
                    'initialPreviewShowDelete' => false,
                    'allowedFileExtensions ' => ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'doc', 'rtf'],
                    'previewFileType' => ['images'],
                    'uploadUrl' => Url::to(['upload']),
                  ],
                  'pluginEvents' => [
                    'fileuploaded' => 'function(e, response) {var result = response.response[0]; $(\'input[name="scans"]\').val(result); }'
                  ]
              ]); ?>
              <?php echo Html::hiddenInput('scans', $data['scans'], ['class'=>'bevalidate']); ?>
          </div>
        </div>

        <?php ActiveForm::end(); ?>
      </div>
      <div class="row">
        <div class="col-xs-6 col-sm-3 col-md-4 col-lg-3" style="margin-top:40px">
          <button class="back-btn pull-left" data-step="<?= Yii::$app->session['step'] - 1?>">НАЗАД</button>
        </div>
        <div class="create-info hidden-xs col-sm-6 col-md-4 col-lg-6 text-center" style="margin-top:30px">

        </div>
        <div class="col-xs-6 col-sm-3 col-md-4 col-lg-3" style="margin-top:40px">
          <button class="step6 next-btn pull-right" >ДАЛЕЕ</button>
        </div>
      </div>

    </div>
  </div>
</div>
</div>
