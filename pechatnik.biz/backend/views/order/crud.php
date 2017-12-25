<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Delivery;
use backend\helpers\CityHelper;
use backend\helpers\ClientHelper;
use backend\helpers\ProducerHelper;
use backend\helpers\ClicheHelper;
use backend\helpers\StampHelper;
use backend\helpers\PaymentHelper;
use backend\helpers\DeliveryHelper;
use backend\helpers\ClicheTplHelper;
use backend\helpers\ClicheSizeHelper;
use backend\helpers\OrderHelper;
use backend\models\Order;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model backend\models\Order */

$this->title = $model->isNewRecord ? 'Создать заказ' : 'Изменить заказ VRN'. $model->number;

Url::remember(Url::current(), 'url-order');

$this->registerJS("
$(document).ready(function(){
  var sc = '".$model->scans."';
  if( sc !== ''){
    $('.file-caption-name').html('".Html::a('Сканы', Yii::$app->request->baseUrl.'/files/scans/'.$model->scans,[])."');
  }
});
");

$this->registerJs("
function getImage(){
  var stamp = $('#order-id_stamp').val();
  if(stamp !== null){
    $.ajax({
       url: '".Url::to(['/producer-stamp/get_image'])."',
       type: 'GET',
       data: {'stamp' :stamp},
       success: function(data) {
           $('#stamp-image').html(data);
       },
    });
  }else{
    $('#stamp-image').html('');
  }
}
");

$this->registerJs("
function getProducer(){
  var id_stamp = $('#order-id_stamp').val();
  var id_cliche_tpl = $('#order-id_cliche_tpl').val();
  $.ajax({
     url: '".Url::to(['/producer/get_producer'])."',
     type: 'GET',
     data: {'id_cliche_tpl' : id_cliche_tpl, 'id_stamp' :id_stamp},
     success: function(data) {
         $('#order-id_producer').html(data);
     },
  });
}
");

$this->registerJs("
$('#order-id_stamp').on('change', function() {
  getImage();
  getProducer();
});
");

$this->registerJs("
$('#order-id_producer').on('change', function() {
  $('#order-id_delivery').val('');
  $('#order-delivery_address').empty();
});
");

$this->registerJs("
$('.create-client').click(function () {
     $.ajax({
        url: '".Url::to(['/client/create'])."',
        type: 'GET',
        data: {'from' : 'order'},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        },
     });
   });
");

$this->registerJs("
$('#cliche').on('change',function(){
  var id_producer = $('#order-id_producer').val();
  var id_cliche = $(this).val();
  $.ajax({
     url: '".Url::to(['/order/get_data'])."',
     type: 'GET',
     data: {'id_cliche' :id_cliche},
     dataType: 'json',
     success: function(data) {
         $('#order-id_cliche_size').html(data.cliche_sizes);
         $('#order-id_cliche_tpl').html(data.cliche_tpl);
         $('#order-id_stamp').html(data.stamps);
         $('#cliche_fields').html(data.fields);
         $('#svg_tpl').html(data.svg);
         getImage();
         getProducer();
     },
  });
});
");

$this->registerJs("
$('#order-id_cliche_tpl').on('change',function(){
  var id_cliche_tpl = $(this).val();
  $.ajax({
     url: '".Url::to(['/cliche-tpl/get_data'])."',
     type: 'GET',
     data: {'id_cliche_tpl' :id_cliche_tpl},
     dataType: 'json',
     success: function(data) {
         $('#svg_tpl').html(data.image);
         $('#cliche_fields').html(data.fields);
     },
  });
});
");

$this->registerJs("
$('#order-id_cliche_size').on('change',function(){
  var id_size = $(this).val();
  $.ajax({
     url: '".Url::to(['/stamp/get_stamp'])."',
     type: 'GET',
     data: {'id_size' :id_size},
     success: function(data) {
         $('#order-id_stamp').html(data);
         getImage();
     },
  });
});
");

$this->registerJs("
$('#order_payment').on('change',function(){
    var payment = $(this).val();
    if(payment == 1){
      $('#order-payment_block').removeClass('hidden');
    }else{
      $('#order-payment_block').addClass('hidden');
    }
});
");

$this->registerJs("
$('#order-id_delivery').on('change',function(){

   if($(this).val() == ".Delivery::TYPE_PICKUP."){
     var id_producer = $('#order-id_producer').val();
     $.ajax({
        url: '".Url::to(['/delivery/get_pickups'])."',
        type: 'GET',
        data: {'id_producer': id_producer},
        success: function(data) {
            $('#delivery_address').html(data);
        },
     });
   }else{
     $('#delivery_address').html('<div class=\"form-group field-order-delivery_address required\">'+
        '<label class=\"control-label\" for=\"order-delivery_address\">Адрес получения</label>'+
        '<input id=\"order-delivery_address\" class=\"form-control\" name=\"Order[delivery_address]\" aria-required=\"true\" type=\"text\">'+
        '<div class=\"help-block\"></div>'+
        '</div>');
   }

});

$('#cliche_fields').on('input', '#inn_ooo',function() {
	var text = $(this).val();
  if(text === ''){
    var text = '1234567890';
  }
  $('#cliche_inn').text(text);
});

$('#cliche_fields').on('input', '#ogrn_ooo',function() {
	var text = $(this).val();
  if(text === ''){
    var text = '123456789012';
  }
  $('#cliche_ogrn').text(text);
});

$('#cliche_fields').on('input', '#city',function() {
	var text = $(this).val();
  if(text === ''){
    var text = 'Воронеж';
  }
  $('#cliche_city').text(text);
});

$('#orders-form').on('submit', function(){
  $('#svg_h').val($('#svg_tpl').html());
});


");
$clientTpl = ["template"=>"{label}
    <div class=\"input-group\">
    {input}
    <div class=\"input-group-btn\">
      <button type=\"button\" class=\"create-client btn-flat btn btn-success\"><i class=\"fa fa-plus\"></i></button>
    </div>
    </div>{hint}{error}"];

?>
<div class="orders-create">

  <div class="box box-primary">
      <div class="box-header with-border">
          <h4 class="box-title"><?= Html::encode($this->title) ?></h4>
          <div class="box-tools ">

          </div>
      </div>
      <div class="box-body ">

          <?php $form = ActiveForm::begin(['id'=>'orders-form', 'options'=>['enctype'=>'multipart/form-data'], 'enableAjaxValidation' => true, 'validateOnChange' => false,'validateOnSubmit' => true, 'enableClientValidation' => false]); ?>
          <?= Html::activeHiddenInput($model, 'svg', ['id' => 'svg_h']); ?>
          <div class="row">
            <div id="stamp-image" class="col-md-4 text-center" style="padding-top:30px">
                <?= $model->isNewRecord ? '' : Html::img(Url::to(Yii::$app->request->baseUrl.'/images/stamp/'.$model->stamp->image, true), ['style'=>'max-height:200px']);  ?>
            </div>
            <div id="svg_tpl" class="col-md-4 text-center">
                <?= $model->isNewRecord ? '' : $model->svg ?>
            </div>
            <div class="col-md-4">
              <?= $form->field($model, 'id_client', $clientTpl)->dropDownList(ClientHelper::getAllNames(),['prompt'=>'- Клиент -']) ?>
              <div class="row">
                <div class="col-md-6">
                  <?= Html::label('Печать', 'for', ['class' => 'control-label']); ?>
                  <?= Html::dropDownList('id_cliche', $id_cliche, ClicheHelper::getAllNames(), ['id'=>'cliche','class' => 'form-control', 'prompt'=>'- Печать -']); ?>
                </div>
                <div class="col-md-6">
                  <?= $form->field($model, 'id_cliche_tpl')->dropDownList($model->isNewRecord ? [] : ClicheTplHelper::listByCliche($id_cliche),['prompt'=>'- Макет печати -']) ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <?= $form->field($model, 'id_cliche_size')->dropDownList($model->isNewRecord ? [] : ClicheSizeHelper::listByCliche($id_cliche),['prompt'=>'- Размер печати -']) ?>
                </div>
                <div class="col-md-6">
                  <?= $form->field($model, 'id_stamp')->dropDownList($model->isNewRecord ? [] : StampHelper::listBySize($model->id_cliche_size) ,['prompt'=>'- Оснастка -']) ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-9">
                  <?= $form->field($model, 'id_producer')->dropDownList($model->isNewRecord ? [] : ProducerHelper::getListByAttributes($model->id_cliche_tpl, $model->id_stamp),['prompt'=>'- Изготовитель -']) ?>
                </div>
                <div class="col-md-3">
                  <?= $form->field($model, 'quantity')->textInput() ?>
                </div>
              </div>

            </div>
          </div>
          <div id="cliche_fields" class="row">
              <?=  $model->isNewRecord ? '' : $this->render('_fields',['fields'=>$fields]); ?>
          </div>
          <div class="row">
            <div class="col-md-4">
              <?= $form->field($model, 'id_payment')->dropDownList(PaymentHelper::getAllNames(),['id'=>'order_payment','prompt'=>'- Способ оплаты -']) ?>
            </div>
            <div class="col-md-3">
              <?= $form->field($model, 'id_delivery')->dropDownList(DeliveryHelper::getAllTypes(),['prompt'=>'- Способ получения -']) ?>
            </div>
            <div id="delivery_address" class="col-md-5">
              <?= $model->isNewRecord ? $form->field($model, 'delivery_address')->textInput() : $model->id_delivery == 2 ?  $form->field($model, 'delivery_address')->dropDownList(DeliveryHelper::getListByProducer($model->id_producer),[])->label('Пункты выдачи') : $form->field($model, 'delivery_address')->textInput()?>
            </div>
          </div>
          <div id="order-payment_block" class="row <?= $model->id_payment == 1 ? '' : 'hidden'?>">
            <div class="col-md-4">
              <?= $form->field($model, 'payment_inn')->textInput() ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'payment_person')->textInput() ?>
            </div>
            <div class="col-md-5">
                <?= $form->field($model, 'payment_address')->textInput() ?>
            </div>
          </div>
          <div class="row">
              <div id="scan" class="col-md-3 <?= $model->isNewRecord ? 'hidden' : $model->producer->need_scan_docs == 0 ? 'hidden' : ''?> ">
                <?= $form->field($model, 'scansFile')->widget(FileInput::classname(), [
                    'options' => ['multiple' => false, 'accept' => ['image/*', 'rtf', 'doc', 'docx', 'svg', 'pdf']],
                    'pluginOptions' => [
                        'browseLabel' => 'Выбрать файл...',
                        'removeLabel' => '',
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showUpload' => false
                    ]
                ]);  ?>
            </div>

              <div id="info" class="col-md-<?= $model->isNewRecord ? '10' : $model->producer->need_scan_docs == 0 ? '10' : '7'?> ">
                <?= $form->field($model, 'info')->textInput() ?>
              </div>
              <div class="col-md-2">
                <?= $form->field($model, 'status')->dropDownList(OrderHelper::getAllStats(),['disabled'=>$model->status == Order::STATUS_CLOSE ? true : false]) ?>
              </div>

          </div>
        </div>
        <div class="box-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-primary btn-flat']) ?>
        </div>
        <?php ActiveForm::end(); ?>
      </div>

</div>
