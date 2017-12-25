<?php
use backend\helpers\OrderHelper;
use backend\helpers\MessageHelper;
 ?>
<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-th-list"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Новых заказов</span>
              <span class="info-box-number"><?= OrderHelper::countNew() ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-flag-checkered"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Заказов к выдаче</span>
              <span class="info-box-number"><?= OrderHelper::countDone() ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-calendar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Всего заказов</span>
              <span class="info-box-number"><?= OrderHelper::countByMonth() ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-envelope"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Сообщений</span>
              <span class="info-box-number"><?= MessageHelper::countNew() ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
