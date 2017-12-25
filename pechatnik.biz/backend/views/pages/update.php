<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pages */

$this->title = 'Страница - '.$model->name;
?>

<div id="producer-tabs" class="nav-tabs-custom">
    <ul class="nav nav-tabs  pull-right">
        <li class="pull-left header"><?= Html::encode($this->title) ?></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="pages">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>