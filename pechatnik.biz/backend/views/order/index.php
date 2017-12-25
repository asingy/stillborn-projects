<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Все заказы';

?>
<div class="orders-index">

  <div class="messages-index">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title"><?= Html::encode($this->title) ?></h4>
            <div class="box-tools ">
                <?= Html::a('Создать заказ', ['create'], ['class' => 'btn btn-flat btn-sm btn-success']); ?>
            </div>
        </div>
        <div class="box-body table-responsive no-padding">
          <?= $this->render('_grid',['dataProvider'=>$dataProvider, 'searchModel'=>$searchModel])  ?>
        </div>
      </div>
</div>
