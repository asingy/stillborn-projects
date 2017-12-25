<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\grid\GridView;
?>

<?php $form = ActiveForm::begin(['id'=>'citys-form','enableAjaxValidation' => true, 'validateOnSubmit' => true]); ?>
<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">
        Макеты печатей
      </h4>
    </div>
    <div class="modal-body table-responsive no-padding">

      <?php Pjax::begin(['id' => 'produser-stamp-tpl-pjax']); ?>
      <?= GridView::widget([
              'id' => 'produser-stamp-tpl-modal',
              'dataProvider' => $dataProvider,
              // 'filterModel' => $searchModel,
              'tableOptions'=>['class'=>'table table-striped'],
              'columns' => [
                  // ['class' => 'yii\grid\SerialColumn'],
                  ['class' => 'yii\grid\CheckboxColumn'],
                  ['attribute'=>'image','format'=>'html', 'value'=>function ($model)
                  {
                    return Html::img(Url::to(Yii::$app->request->baseUrl.'/images/cliche_tpl/'.$model->image, true), ['width'=>'100px']);
                  }],
                  // 'id',
                  // ['attribute'=>'id_type','format'=>'html', 'filter'=>StampTypesHelper::getAllNames(), 'value'=>function ($model)
                  // {
                  //   return StampTypesHelper::getName($model->id_type);
                  // }],
                  'name:ntext',
                  'info:ntext',

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
