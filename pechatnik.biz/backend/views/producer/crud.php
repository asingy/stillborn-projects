<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Contacts */

$this->title = $model->isNewRecord ? 'Создать' : $contact->name;

Url::remember(Url::current(), 'url-producer');
Url::remember(Url::current(), 'url-delivery');

$this->registerJs("
    $(document).ready(function(){
    $('a[data-toggle=\"tab\"]').on('show.bs.tab', function(e) {
        localStorage.setItem('active-producer-tab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('active-producer-tab');
    if(activeTab){
        $('#producer-tabs a[href=\"' + activeTab + '\"]').tab('show');
    }
  });
");
?>


<div id="producer-tabs" class="nav-tabs-custom">
    <ul class="nav nav-tabs  pull-right">
      <li class=""><?= $model->isNewRecord ? '' : Html::a('Адреса выдачи', '#delivery', ['data-toggle'=>"tab"]); ?></li>
      <li class=""><?= $model->isNewRecord ? '' : Html::a('Оснастки', '#stamp', ['data-toggle'=>"tab"]); ?></li>
      <li class=""><?= $model->isNewRecord ? '' : Html::a('Макеты печатей', '#cliche_tpl', ['data-toggle'=>"tab"]); ?></li>
      <li class=""><?= $model->isNewRecord ? '' : Html::a('Цены на печати', '#cliche_prices', ['data-toggle'=>"tab"]); ?></li>
      <li class="active"><?= Html::a('Изготовитель', '#producer', ['data-toggle'=>"tab"]); ?></li>
      <li class="pull-left header"><?= Html::encode($this->title) ?></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="producer">
            <?= $this->render('_form', ['contact' => $contact, 'model' => $model]) ?>
        </div>

        <div class="tab-pane" id="cliche_prices">
            <?= $model->isNewRecord ? '' : $this->render('_cliche_price', ['model'=>$model, 'dataProvider'=>$dpClichePrice]); ?>
        </div>

        <div class="tab-pane" id="cliche_tpl">
            <?= $model->isNewRecord ? '' : $this->render('_cliche_tpl', ['model'=>$model, 'dataProvider'=>$dpClicheTpl]); ?>
        </div>

        <div class="tab-pane" id="stamp">
            <?= $model->isNewRecord ? '' : $this->render('_stamp', ['model'=>$model, 'dataProvider'=>$dpStamp]); ?>
        </div>

        <div class="tab-pane" id="delivery">
            <?= $model->isNewRecord ? '' : $this->render('_delivery', ['model'=>$model, 'dataProvider'=>$dpDelivery, 'contact_type'=>$contact->type]); ?>
        </div>

    </div>
</div>
