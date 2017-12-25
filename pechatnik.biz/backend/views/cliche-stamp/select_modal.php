<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\grid\GridView;


?>

<?php $form = ActiveForm::begin(['id'=>'citys-form','enableAjaxValidation' => true, 'validateOnSubmit' => true]); ?>
<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">
        Оснастки
      </h4>
    </div>
    <div class="modal-body table-responsive no-padding">

<?php Pjax::begin(['id' => 'stamp-pjax']); ?>
      <?= GridView::widget([
              'id' => 'stamp-cases-modal',
              'dataProvider' => $dataProvider,
              // 'filterModel' => $searchModel,
              'tableOptions'=>['class'=>'table table-striped'],
              'columns' => [
                  ['class' => 'yii\grid\CheckboxColumn'],
                  ['attribute'=>'image','format'=>'html', 'value'=>function ($model)
                  {
                    return Html::img(Url::to(Yii::$app->request->baseUrl.'/images/stamp/'.$model->image, true), ['width'=>'100px']);
                  }],
                  // 'id',
                  'name:ntext',
                  // 'info:ntext',
                  // ['attribute'=>'id_stamp_type','format'=>'html', 'filter'=>StampTypesHelper::getAllNames(), 'value'=>function ($model)
                  // {
                  //   return StampTypesHelper::getName($model->id_stamp_type);
                  // }],
                  // ['attribute'=>'status','format'=>'html', 'filter'=>StampCasesHelper::getAllStats(), 'value'=>function ($model)
                  // {
                  //   return StampCasesHelper::getStatusLabels($model->status);
                  // }],
                  // 'order',

                  // ['class' => 'yii\grid\ActionColumn','template'=>'{update} {delete}','buttons'=>[
                  //           'update'=>function ($url, $model) {
                  //               return Html::button('<i class="glyphicon glyphicon-edit"></i>', ['data-id'=>$model->id, 'class'=>'update btn btn-flat btn-primary btn-xs']);
                  //           },
                  //           'delete'=>function ($url, $model) {
                  //               return Html::a('<i class="glyphicon glyphicon-trash"></i>',['delete', 'id'=>$model->id],[
                  //                   'data' => [
                  //                       'confirm' => 'Точно хотите удалить?',
                  //                       'method' => 'post',
                  //                   ],'class'=>'btn btn-flat btn-danger btn-xs',
                  //               ]);
                  //           },
                  //       ],'contentOptions'=>['class'=>'text-right col-md-1']],
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
