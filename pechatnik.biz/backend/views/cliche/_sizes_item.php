<?php
use yii\helpers\Html;
 ?>
 <div class="col-sm-2" >
  <?= Html::button($model->size, ['class' => 'col-sm-12 update_size btn btn-default btn-flat', 'style'=>'margin:5px 0;','data-id'=>$model->id]); ?>
</div>
