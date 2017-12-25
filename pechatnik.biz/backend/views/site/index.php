<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;

use kartik\date\DatePicker;
use backend\helpers\OrderHelper;

/* @var $this yii\web\View */

$this->title = 'Главная';

?>
<div class="site-index">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title">Заказы в работе</h4>
            <div class="box-tools ">
                <?= Html::a('Создать заказ', ['/order/create'], ['class' => 'btn btn-flat btn-sm btn-success']); ?>
            </div>
        </div>
        <div class="box-body table-responsive no-padding">
          <?= $this->render('/order/_grid',['dataProvider'=>$dataProvider, 'searchModel'=>$searchModel])  ?>
        </div>
    </div>

</div>
