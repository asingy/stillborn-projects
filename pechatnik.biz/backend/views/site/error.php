<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>

        <div class="error-content">
            <br>
            <br>
            <h4> Упс ... что-то сломалось <br> Расскажите об этой ошибке разработчику </h4>

            <h4><?= $name ?></h4>

            <p>
                <?= nl2br(Html::encode($message)) ?>
            </p>

        </div>
    </div>

</section>
