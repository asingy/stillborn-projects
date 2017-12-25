<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\search\Pages */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страницы';
?>
<div class="pages-index">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title"><?= Html::encode($this->title) ?></h4>
            <div class="box-tools ">
                <?= Html::a('Создать страницу', ['create'], ['class' => 'btn btn-flat btn-sm btn-success']); ?>
            </div>
        </div>
        <div class="box-body table-responsive no-padding">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'name',
                    'slug',
                    [
                        'attribute' => 'content',
                        'value' => function($value) {
                            return iconv_substr(strip_tags($value->content), 0, 200).'...';
                        }
                    ],
                    'meta_title',
                    // 'meta_keywords',
                    // 'meta_description',
                    // 'author_id',
                     'created_at:datetime',
                     'updated_at:datetime',

                    ['class' => 'yii\grid\ActionColumn','template'=>'{update} {delete}','buttons'=>[
                        'update'=>function ($url, $model) {
                            return Html::a('<i class="glyphicon glyphicon-edit"></i>', ['/pages/update', 'id'=>$model->id], ['class'=>'update btn btn-flat btn-primary btn-xs']);
                        },
                        'delete'=>function ($url, $model) {
                            return Html::a('<i class="glyphicon glyphicon-trash"></i>',['/pages/delete', 'id'=>$model->id],[
                                'data' => [
                                    'confirm' => 'Точно хотите удалить?',
                                    'method' => 'post',
                                ],'class'=>'btn btn-flat btn-danger btn-xs',
                            ]);
                        },
                    ],'contentOptions'=>['class'=>'text-right col-md-1']],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

</div>
