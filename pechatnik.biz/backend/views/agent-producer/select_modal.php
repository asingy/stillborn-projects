<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\helpers\CityHelper;
use yii\widgets\Pjax;
use yii\grid\GridView;
?>

<?php $form = ActiveForm::begin(['id'=>'citys-form','enableAjaxValidation' => true, 'validateOnSubmit' => true]); ?>
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">
        Изготовители
      </h4>
    </div>
    <div class="modal-body table-responsive no-padding">

      <?php Pjax::begin(['id' => 'agent-produsers-pjax']); ?>
      <?= GridView::widget([
              'id' => 'agent-produsers-modal',
              'dataProvider' => $dataProvider,
              // 'filterModel' => $searchModel,
              'tableOptions'=>['class'=>'table table-striped'],
              'columns' => [
                  // ['class' => 'yii\grid\SerialColumn'],
                  ['class' => 'yii\grid\CheckboxColumn'],

                  ['attribute'=>'contact.id_city','format'=>'html', 'filter'=> CityHelper::getAll(), 'value'=>function ($model)
                  {
                    return CityHelper::getById($model->contact->id_city);
                  }],
                  'contact.name',
                  'contact.cname',
                  'contact.contact_person',
                  'contact.contact_phone',
              ],
          ]); ?>
      <?php Pjax::end(); ?>

    </div>
    <div class="modal-footer">
         <?= Html::submitButton('Добавить', ['class' => 'pull-right btn-flat btn btn-primary']) ?>
    </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
