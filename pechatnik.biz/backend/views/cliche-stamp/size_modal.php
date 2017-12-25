<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\grid\GridView;

$this->registerJs("$('.size_check').on('change',function () {
      var id_cliche_size = $(this).val();
     $.ajax({
        url: '".Url::to(['/cliche-stamp/change_size'])."',
        type: 'POST',
        data: {'id_cliche':".$id_cliche.", 'id_cliche_stamp': ".$id_cliche_stamp.", 'id_cliche_size': id_cliche_size},
        success: function(data) {

        },
     });
    })");
?>


<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">
        Размеры печати
      </h4>
    </div>
    <div class="modal-body">
    <div class="row">
      <div id="cb" class="">

        <?= empty($sizes) ? 'Размеры печати не определены' : Html::checkboxList('selection', $selected, $sizes, ['item'=>function ($index, $label, $name, $checked, $value){
            return Html::checkbox($name, $checked, [
               'value' => $value,
               'label' => $label,
               'labelOptions' => ['class'=>'col-sm-2 text-center c-box'],
               'class' => 'size_check',
            ]);
        }]); ?>
      </div>
    </div>


    </div>
    <div class="modal-footer">
         <?= Html::a('Изменить', Url::previous('url-cliche'), ['class' => 'pull-right btn-flat btn btn-primary']) ?>
    </div>
    </div>
</div>
