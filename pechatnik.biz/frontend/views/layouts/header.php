<div id="header" class="header text-center bg-light">
  <div class="container">
    <div class="row">
      <div class="row">
        <div class="col-xs-4 text-center">
          <div class="logo">
            <a href="/">
              <img src="/images/logoPechatnik1.svg" alt="logo">
            </a>
          </div>
        </div>
        <div class="col-xs-4 text-center">
          <div class="price  hidden-lg hidden-md" style="margin-top:3px">
            <span style="padding: 5px 10px; background-color: #ccc "><span class="hidden-xs"> Сумма заказа </span>
              <strong><span class="header-price"><?= isset(Yii::$app->session['price']) ? Yii::$app->session['price'] : '0' ?></span> p.</strong>
            </span>
          </div>
          <div class=" hidden-sm hidden-xs" style="margin-top:5px; font-size:18px">
            Сумма заказа <strong><span class="header-price"><?= isset(Yii::$app->session['price']) ? Yii::$app->session['price'] : '0' ?></span> p.</strong>
          </div>
        </div>
        <div class="col-xs-4 text-center">
          <div class="menu-wrapper">
            <button class="menu-toggle  hamburger hamburger--arrowalt-r">
              <span class="hamburger-box">
                <span class="hamburger-inner"></span>
              </span>
            </button>
            <div class="main-menu">
              <nav>
                <ul>
                  <li>
                    <a href="/#monitor">Отследить заказ</a>
                  </li>
                  <li>
                    <a href="/#create">Заказать печать</a>
                  </li>
                  <li>
                    <a href="/#faq">Вопрос-ответ </a>
                  </li>
                  <li>
                    <a href="#contact">Контакты</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<span class="menu-overlay"></span>
