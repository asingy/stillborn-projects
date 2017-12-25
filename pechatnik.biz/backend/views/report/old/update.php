<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ReportAgent */

$this->title = 'Update Report Agent: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Report Agents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="report-agent-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
