<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\helpers\ClicheHelper;
use yii\widgets\Pjax;
use yii\grid\GridView;
?>

<?php $form = ActiveForm::begin(['id'=>'citys-form','enableAjaxValidation' => true, 'validateOnSubmit' => true]); ?>
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">
        Оснастки
      </h4>
    </div>
    <div class="modal-body table-responsive no-padding">

      <?php Pjax::begin(); ?>
      <?= GridView::widget([
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
                  ['attribute'=>'id_cliche','format'=>'html', 'filter'=>ClicheHelper::getAllNames(), 'value'=>function ($model)
                  {
                    return ClicheHelper::getName($model->id_cliche);
                  }],
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
