<div id="contact" class="contact-area bg-gray ptb-50">
  <div class="container">
    <div class="row">
      <div class="section-title title-black text-center col-xs-12">
        <h1 class="text-uppercase">Контакты</h1>
      </div>
      <div class="bg-light contact-info col-md-4 col-md-offset-1 col-sm-8 col-sm-offset-2 col-xs-12">
        <h4><strong>Контактная информация:</strong></h4><br>
        <div>
          <span>Адрес:</span>
          <p><?= $data['address']  ?></p>
        </div>
        <div>
          <span>Телефоны:</span>
          <p><?= $data['tel1']  ?><br><?= $data['tel2']  ?></p>
        </div>
        <div>
          <span>Email:</span>
          <p><a href="#"><?= $data['email']  ?></a></p>
        </div>
        <div>
          <span>Телеграм Бот:</span>
          <p><i class="zmdi zmdi-telegram"></i><?= $data['telegram_bot']  ?></p>
        </div>
        <div>
          <span>Skype Бот :</span>
          <p><i class="zmdi zmdi-telegram"></i>pechatnik</p>
        </div>
      </div>
      <div class="bg-light contact-form col-md-5 col-md-offset-1 col-sm-8 col-sm-offset-2 col-xs-12">
        <h4><strong>Напишите нам:</strong></h4>
        <form id="contact-form" action="#" method="post">
          <div class="decorate-input">
            <input name="name" type="text" placeholder="Имя" required>
          </div>
          <div class="decorate-input">
            <input name="phone" placeholder="Телефон в формате 7-XXX-XXXXXXX" type="tel" pattern="^\d{1}-\d{3}-\d{7}$">
          </div>
          <div class="decorate-input">
            <input name="email" type="email" placeholder="Email" required>
          </div>
          <div class="decorate-input">
            <textarea name="message" placeholder="Ваше сообщение" required></textarea>
          </div>
          <button class="col-xs-12 col-sm-12 col-md-8 col-lg-6 submit" type="submit">Отправить<i class="zmdi zmdi-mail-send"></i></button>
        </form>
        <p class="form-messege"></p>
      </div>
    </div>
  </div>
</div>
