<?php
use backend\helpers\CityHelper;
use yii\helpers\Html;
$col = 12/count($fields);

$this->registerJS("

$('#inn_ip').on('keypress', function(e){
  var len = $(this).val().length;
  if(len >= 10){
    $(this).val($(this).val().substring(0, len-1));
  }
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
  }
});

$('#inn_ooo').on('keypress', function(e){
  var len = $(this).val().length;
  if(len >= 12){
    $(this).val($(this).val().substring(0, len-1));
  }
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
  }
});

$('#ogrn_ooo').on('keypress', function(e){
  var len = $(this).val().length;
  if(len >= 13 ){
    $(this).val($(this).val().substring(0, len-1));
  }
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
  }
});

$('#ogrn_ip').on('keypress', function(e){
  var len = $(this).val().length;
  if(len >= 15){
    $(this).val($(this).val().substring(0, len-1));
  }
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
  }
});
");
 ?>

<?php foreach ($fields as $key => $value): ?>
  <?php if ($value->field === 'city') {
    $val = Yii::$app->user->identity->city->name;
  }else{
    $val = '';
  } ?>
  <div class="col-md-<?=$col?>">
    <div class="form-group">
      <?= Html::label($value->name, '', ['class' => 'control-label']); ?>
      <?= Html::textInput('Order_fields['.$value->field.']', isset($value->val) ? $value->val : $val, ['id'=>$value->field,'class' => 'form-control']); ?>
    </div>
  </div>
<?php endforeach; ?>
