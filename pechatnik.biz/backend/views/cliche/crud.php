<?php

use yii\helpers\Html;
use backend\helpers\ClicheHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\Contacts */

$this->title = $model->isNewRecord ? 'Создать' : $model->name;

Url::remember(Url::current(), 'url-cliche');

$this->registerJs("
    $(document).ready(function(){
    $('a[data-toggle=\"tab\"]').on('show.bs.tab', function(e) {
        localStorage.setItem('active-cliche-tab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('active-cliche-tab');
    if(activeTab){
        $('#stamp-tabs a[href=\"' + activeTab + '\"]').tab('show');
    }
  });
");
?>


<div id="stamp-tabs" class="nav-tabs-custom">
    <ul class="nav nav-tabs  pull-right">
      <li class=""><?= $model->isNewRecord ? '' : Html::a('Оснастки', '#stamp', ['data-toggle'=>"tab"]); ?></li>
      <li class=""><?= $model->isNewRecord ? '' : Html::a('Макеты печатей', '#cliche', ['data-toggle'=>"tab"]); ?></li>
      <li class="active"><?= Html::a('Печать', '#producer', ['data-toggle'=>"tab"]); ?></li>
      <li class="pull-left header"><?= Html::encode($this->title) ?></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="producer">
            <?= $this->render('_form', ['model' => $model, 'dataProvider'=>$dpStampSizes]) ?>
        </div>

        <div class="tab-pane" id="cliche">
            <?= $model->isNewRecord ? '' : $this->render('_cliche_tpl', ['model'=>$model, 'dataProvider'=>$dpStamps]); ?>
        </div>

        <div class="tab-pane" id="stamp">
            <?= $model->isNewRecord ? '' : $this->render('_stamp', ['model'=>$model, 'dataProvider'=>$dpStampCases]); ?>
        </div>

    </div>
</div>
