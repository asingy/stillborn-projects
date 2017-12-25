<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ReportAgent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-agent-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'id_producer')->textInput() ?>

    <?= $form->field($model, 'cost_producer')->textInput() ?>

    <?= $form->field($model, 'cost_client')->textInput() ?>

    <?= $form->field($model, 'system_reward')->textInput() ?>

    <?= $form->field($model, 'agent_profit')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
