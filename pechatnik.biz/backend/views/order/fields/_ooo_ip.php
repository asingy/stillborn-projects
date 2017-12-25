<?php
use backend\helpers\CityHelper;
use yii\helpers\Html;
 ?>
<div class="col-md-2">
  <div class="form-group">
    <?= Html::label('ИНН', '', ['class' => 'control-label']); ?>
    <?= Html::textInput('Order_fields[inn]', isset($fields->inn) ? $fields->inn : '', ['class' => 'form-control']); ?>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <?= Html::label('ОГРН', '', ['class' => 'control-label']); ?>
    <?= Html::textInput('Order_fields[ogrn]', isset($fields->ogrn) ? $fields->ogrn : '', ['class' => 'form-control']); ?>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <?= Html::label('Наименование', '', ['class' => 'control-label']); ?>
    <?= Html::textInput('Order_fields[name]', isset($fields->name) ? $fields->name : '', ['class' => 'form-control']); ?>
  </div>
</div>
<div class="col-md-5">
  <div class="form-group">
    <?= Html::label('Город', '', ['class' => 'control-label']); ?>
    <?= Html::dropDownList('Order_fields[city]', isset($fields->city) ? $fields->city : '', CityHelper::getAll(), ['class' => 'form-control']); ?>
  </div>
</div>
