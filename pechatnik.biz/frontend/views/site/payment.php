<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = 'Payment...';
?>

<div class="site-yakassa">

    <div class="text-center lead" style="margin-top:200px;color:#3B5998">
        <p class="text-info">Перенаправление на страницу оплаты...</p>
    </div>

<?php
echo Html::beginForm(Yii::$app->yakassa->paymentAction, 'post', ['id'=>'pay-form']);

echo Html::hiddenInput('shopId', Yii::$app->yakassa->shopId);
echo Html::hiddenInput('scid', Yii::$app->yakassa->scId);
echo Html::hiddenInput('sum', $sum);
echo Html::hiddenInput('customerNumber', $customerNumber);
echo Html::hiddenInput('paymentType', $paymentType);
echo Html::hiddenInput('cps_phone', $cps_phone);
echo Html::hiddenInput('cps_email', $cps_email);
echo Html::hiddenInput('orderNumber', $orderNumber);

echo Html::endForm();

$this->registerJs('  $(document).ready(function() {
        $("#pay-form").submit();
    });');
?>

</div>