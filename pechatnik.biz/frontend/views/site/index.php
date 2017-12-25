<?php

/* @var $this yii\web\View */

$this->title = 'Печатник';

if($order !== null){
  $popup = '';
  $title = 'Ваш заказ оформлен';
}else{
  $popup = 'hidden';
  $title = '';
  $order = '';
}
?>

<?= $this->render('blocks/hero.php', ['data' => $data['promo']]); ?>

<?= $this->render('blocks/monitor.php'); ?>

<div id="create" class="create-area bg-create ptb-50 overlay">
  <?= $this->render('blocks/create/_create1', ['data' => $cliche_list]);  ?>
</div>

<?= $this->render('blocks/faq.php', ['data' => $data['faq']]); ?>

<?= $this->render('blocks/contacts.php', ['data' => $data['contacts']]); ?>

<div id="popup" class="<?= $popup ?>">
	<div id="popup-main" class="order-popup col-xs-8 col-sm-4 col-md-3 col-lg-3">
		<p class="popup-header lead text-danger"><?= $title ?></p>
		<p class="popup-text"><?= $order ?></p>
		<button type="button" class="dismiss-btn">Закрыть</button>
	</div>
	<div id="cover" >
</div>
