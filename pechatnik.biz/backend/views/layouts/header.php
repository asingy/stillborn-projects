<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">ПЧ</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Навигация</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->


                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i>
                        <span class="hidden-xs"><?= ucfirst(Yii::$app->user->identity->description) ?></span>
                    </a>
                    <ul class="dropdown-menu">
                            <li class="user-header" style="height:60px;">
                                <p><?= ucfirst(Yii::$app->user->identity->description)  ?></p>
                            </li>
                            <li class="user-footer">
                                <div class="text-center">
                                  <?= Html::a('Выйти из системы', ['/site/logout'], ['class' => 'btn btn-block btn-default btn-flat', 'data-method' =>'post']); ?>
                                    <!-- <a class="btn btn-block btn-default btn-flat" href="/logout" data-method="post"></a></div> -->
                            </li>
                        </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <!-- <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li> -->
            </ul>
        </div>
    </nav>
</header>
