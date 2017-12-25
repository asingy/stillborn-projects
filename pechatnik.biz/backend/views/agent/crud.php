<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Contacts */

Url::remember(Url::current(), 'url-agent');
Url::remember(Url::current(), 'url-delivery');

$this->title = $model->isNewRecord ? 'Создать' : $contact->name;

$this->registerJs("
    $(document).ready(function(){
    $('a[data-toggle=\"tab\"]').on('show.bs.tab', function(e) {
        localStorage.setItem('active-agent-tab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('active-agent-tab');
    if(activeTab){
        $('#agents-tabs a[href=\"' + activeTab + '\"]').tab('show');
    }
  });
");
?>


<div id="agents-tabs" class="nav-tabs-custom">
    <ul class="nav nav-tabs  pull-right">
      <li class=""><?= $model->isNewRecord ? '' : Html::a('Адреса выдачи', '#delivery', ['data-toggle'=>"tab"]); ?></li>
      <li class=""><?= $model->isNewRecord ? '' : Html::a('Изготовители', '#producers', ['data-toggle'=>"tab"]); ?></li>
      <li class="active"><?= Html::a('Агент', '#agent', ['data-toggle'=>"tab"]); ?></li>
      <li class="pull-left header"><?= Html::encode($this->title) ?></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="agent">
            <?= $this->render('_form', ['contact' => $contact, 'model' => $model ]) ?>
        </div>

        <div class="tab-pane" id="producers">
            <?= $model->isNewRecord ? '' : $this->render('_producer', ['model'=>$model, 'dataProvider'=>$dpAgentProducer]); ?>
        </div>

        <div class="tab-pane" id="delivery">
            <?= $model->isNewRecord ? '' : $this->render('_delivery', ['model'=>$model, 'dataProvider'=>$dpDelivery, 'contact_type'=>$contact->type]); ?>
        </div>
    </div>
</div>
