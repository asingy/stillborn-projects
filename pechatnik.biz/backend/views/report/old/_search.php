<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\search\ReportSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-agent-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'order_number') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'id_producer') ?>

    <?= $form->field($model, 'cost_producer') ?>

    <?php // echo $form->field($model, 'cost_client') ?>

    <?php // echo $form->field($model, 'system_reward') ?>

    <?php // echo $form->field($model, 'agent_profit') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
