<?php
use backend\helpers\CityHelper;
use yii\helpers\Html;
 ?>

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
<div class="col-md-2">
  <div class="form-group">
    <?= Html::label('Шаблон', '', ['class' => 'control-label']); ?>
    <?= Html::dropDownList('Order_fields[text_tpl]', isset($fields->text_tpl) ? $fields->text_tpl : '', [1=>'Для справок'], ['class' => 'form-control']); ?>
  </div>

</div>
<div class="col-md-5">
  <div class="form-group">
    <?= Html::label('Текст', '', ['class' => 'control-label']); ?>
    <?= Html::textInput('Order_fields[text]', isset($fields->text) ? $fields->text : '', ['class' => 'form-control']); ?>
  </div>
</div>
