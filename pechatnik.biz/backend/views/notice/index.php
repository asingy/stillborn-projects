<?php

use backend\helpers\OrderHelper;
use backend\models\Order;
use common\components\Mailer;
use yii\helpers\Html;
use backend\helpers\ClicheHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\Notice */

$this->title = 'Уведомления';

Url::remember(Url::current(), 'url-notice');

$this->registerJs("
    $(document).ready(function(){
    $('a[data-toggle=\"tab\"]').on('show.bs.tab', function(e) {
        localStorage.setItem('active-notice-tab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('active-notice-tab');
    if(activeTab){
        $('#stamp-tabs a[href=\"' + activeTab + '\"]').tab('show');
    }
  });
");
?>


<div id="stamp-tabs" class="nav-tabs-custom">
    <ul class="nav nav-tabs  pull-right">
      <li class="<?=$model->group == Mailer::TEMPLATE_MANUFACTURER ? 'active' : ''?>"><?= Html::a('Производителю', ['index','id'=> Mailer::TEMPLATE_MANUFACTURER]); ?></li>
      <li class="<?=$model->group == Mailer::TEMPLATE_AGENT ? 'active' : ''?>"><?= Html::a('Агенту', ['index','id'=> Mailer::TEMPLATE_AGENT]); ?></li>
      <li class="<?=$model->group == Mailer::TEMPLATE_AGENT_AUTO ? 'active' : ''?>"><?= Html::a('Агенту (через два дня)', ['index','id'=> Mailer::TEMPLATE_AGENT_AUTO]); ?></li>
      <li class="<?=$model->group == Mailer::TEMPLATE_USER ? 'active' : ''?>"><?= Html::a('Пользователю', ['index','id'=> Mailer::TEMPLATE_USER]); ?></li>
      <li class="pull-left header"><?= Html::encode($this->title) ?></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active">
            <?php for($i=0; $i <= 7; $i++): ?>
                <?php $title = OrderHelper::getStatusLabels($i); ?>
                <hr/>
                <h3><?php echo $title ?></h3>

                <?php if (isset($group[$i]) && $template = $group[$i]): ?>
                    <?= $this->render('_form', ['model' => $template]) ?>
                <?php endif; ?>
            <?php endfor; ?>
        </div>

    </div>
</div>
