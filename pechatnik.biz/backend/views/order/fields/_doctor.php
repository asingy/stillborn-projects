<?php
use backend\helpers\CityHelper;
use yii\helpers\Html;
 ?>

<div class="col-md-4">
  <div class="form-group">
    <?= Html::label('Ф.И.О', '', ['class' => 'control-label']); ?>
    <?= Html::textInput('Order_fields[name]', isset($fields->name) ? $fields->name : '', ['class' => 'form-control']); ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <?= Html::label('Специальность', '', ['class' => 'control-label']); ?>
    <?= Html::dropDownList('Order_fields[spec]', isset($fields->spec) ? $fields->spec : '', [1=>'Хирург', 2=>'Терапевт'], ['class' => 'form-control']); ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <?= Html::label('Текст', '', ['class' => 'control-label']); ?>
    <?= Html::textInput('Order_fields[text]', isset($fields->text) ? $fields->text : '', ['class' => 'form-control']); ?>
  </div>
</div>
