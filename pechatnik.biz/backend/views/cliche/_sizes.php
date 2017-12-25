<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->registerJs("$('.create_size').click(function () {
     $.ajax({
        url: '".Url::to(['/cliche-size/create'])."',
        type: 'GET',
        data: {'id_cliche' : ".$model->id."},
        success: function(data) {
            $('#myModal').html(data);
            $('#myModal').modal();
        },
     });
    })");
    $this->registerJs("$('.update_size').click(function () {
         $.ajax({
            url: '".Url::to(['/cliche-size/update'])."',
            type: 'GET',
            data: {id : $(this).data('id')},
            success: function(data) {
                $('#myModal').html(data);
                $('#myModal').modal();
            },
         });
        })");
 ?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title">Размеры</h4>
        <div class="box-tools ">
            <?= Html::button('Добавить', ['class' => 'create_size btn btn-flat btn-sm btn-success']); ?>
        </div>
    </div>
    <div class="box-body">

          <?php $pjax = Pjax::begin(['id'=>'sizes-list']); ?>

          <?= ListView::widget([
          'id' => 'stamp-sizes-id',
            'dataProvider' => $dataProvider,
            'layout'=>"{items}\n{pager}",
           'itemView' => '_sizes_item',
            'options' => [
                'tag' => 'div',
                'class' => ''
            ],
            // 'pager' => [
            //     // 'class' => InfiniteScrollPager::className(),
            //     'pjaxContainer' => $pjax->id,
            //     'containerSelector' => '.search-list1',
            //     'wrapperSelector' => '.search-list1',
            //     'itemSelector' => '.tail',
            // ],
        ]);
      ?>

      <?php Pjax::end(); ?>
    </div>
  </div>
