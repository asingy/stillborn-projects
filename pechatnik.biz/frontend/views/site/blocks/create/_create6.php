<?php
use frontend\helpers\OrderHelper;
use frontend\helpers\DeliveryHelper;
use frontend\helpers\ClicheHelper;

  $this->registerJS("

  $('.therms-of-use').on('click', function (e) {
  	$('#popup-main').addClass('therms-popup');
  	$('#popup-terms').removeClass('hidden');
  });

  $('.dismiss-terms-btn').on('click', function (e) {
  	$('#popup-terms').addClass('hidden');
  });

  ");
 ?>
 
<div id="create6" >
  <div class="container">
    <div class="row">
      <div class="row">
        <div class="create-title section-title title-black text-center col-xs-12">
          <h1>ЗАКАЗАТЬ ПЕЧАТЬ</h1>
          <h3>6. Отправка заказа</h3>
        </div>
      </div>

      <div class="step6-cont row">

        <div class="col-sm-12 col-md-6" style="">
          <div class="col-sm-6 col-md-6 text-center" style="margin: 20px 0">
            <img src="admin/images/stamp/<?= $data['stamp_image'] ?>" alt="оснастка">
          </div>
          <div id="cliche_image" class="col-sm-6 col-md-6 text-center" style="margin: 20px 0">

              <?= Yii::$app->session['svg']  ?>

          </div>
        </div>
        <div class="create-block col-sm-12 col-md-6">
          <div style="margin-left:20px">
            <p><strong>Имя: </strong><?= $data['name'] ?></p>
            <p><strong>Телефон: </strong><?= $data['phone'] ?></p>
            <p><strong>Электронная почта: </strong><?= $data['email'] ?></p>
            <p><strong>Оснастка: </strong><?= $data['stamp_name'] ?></p>
            <p><strong>Размер печати: </strong><?= ClicheHelper::getSize($data['cliche_size']) ?>мм.</p>
            <p><strong>Количество: </strong><?= $data['quantity'] ?>шт.</p>
            <p><strong>Способ получение: </strong><?= DeliveryHelper::getDeliveryType($data['id_delivery']) ?></p>
            <p><strong>Адрес получения: </strong><?= DeliveryHelper::getDeliveryAddress($data['delivery_address']) ?></p>
            <p><strong>Способ оплаты: </strong><?= OrderHelper::getPayment($data['id_payment']) ?></p>
            <p><strong>Итого: </strong><?= Yii::$app->session['cost']?> p.</p>
            <div id="id-agree" class="checkbox">
              <label><input id="agree" type="checkbox" name="agreement" value="1">Я согласен с <span class="therms-of-use">условиями сервиса</span></label>
            </div>
          </div>
        </div>
      </div>
      <div class="row text-center" style="margin-top:40px">
        <div class="col-xs-6">
          <button class="back-btn pull-left" data-step="<?= Yii::$app->session['step'] - 1 ?>">НАЗАД</button>
        </div>
        <div class="col-xs-6">
          <button class="order-btn pull-right" >ЗАКАЗАТЬ</button>
        </div>
      </div>

    </div>
  </div>
</div>
</div>

<div id="popup-terms" class="hidden">
	<div id="popup-main" class="therms-popup col-xs-8 col-sm-4 col-md-3 col-lg-3">
		<p class="popup-header lead text-danger">Условия использования сервиса</p>
		<p class="popup-text"><?= $data['terms']  ?></p>
		<button type="button" class="dismiss-terms-btn">Закрыть</button>
	</div>
	<div id="cover" >
</div>
