<?php
use backend\helpers\CityHelper;
use yii\helpers\Html;
 ?>

<div class="col-md-6">
  <div class="form-group">
    <?= Html::label('Шаблоны', '', ['class' => 'control-label']); ?>
    <?= Html::dropDownList('Order_fields[text_tpl]', isset($fields->text_tpl) ? $fields->text_tpl : '', [1=>'Копия верна'], ['class' => 'form-control']); ?>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <?= Html::label('Текст', '', ['class' => 'control-label']); ?>
    <?= Html::textInput('Order_fields[text]', isset($fields->text) ? $fields->text : '', ['class' => 'form-control']); ?>
  </div>
</div>
