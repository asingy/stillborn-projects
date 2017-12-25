<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ReportAgent */

$this->title = 'Create Report Agent';
$this->params['breadcrumbs'][] = ['label' => 'Report Agents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-agent-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
