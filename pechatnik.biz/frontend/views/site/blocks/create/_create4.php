<?php
 use frontend\helpers\ClicheHelper;
 $dataCount = count($data);
?>
<div id="create4" >
  <div class="container">
    <div class="row">
      <div class="row">
        <div class="create-title section-title title-black text-center col-xs-12">
          <h1>ЗАКАЗАТЬ ПЕЧАТЬ</h1>
          <h3>4. Выберите оснастку</h3>
        </div>
      </div>
      <div class="slider">
        <?php foreach ($data as $value): ?>
          <?php $info_array[] = $value->stamp->info; ?>
          <div data-id="<?= $value->stamp->id?>">
            <div class="row stamp">
              <p class="text-left" style="margin:0 0 0 10px">
                <strong ># <?= $value->stamp->id ?></strong>
                <span style="color:#000000"><?= $value->stamp->name ?></span>
              </p>
              <img src="admin/images/stamp/<?= $value->stamp->image?>" alt="оснастка" style="padding:0px; height:150px">
              <p style="margin-top:5px">
                <strong class="text-center" style="color:#3B5998; font-size:18px"><span class="price"><?= $value->stamp->stamp_price->price + ClicheHelper::getPrice() ?></span> р.</strong>
              </p>
            </div>
          </div>
        <?php endforeach; ?>

          <?php if ($dataCount < 4 && $dataCount > 1): ?>
            <?php foreach ($data as $value): ?>
              <?php $info_array[] = $value->stamp->info; ?>
              <div data-id="<?= $value->stamp->id?>">
                <div class="row stamp">
                  <p class="text-left" style="margin:0 0 0 10px">
                    <strong ># <?= $value->stamp->id ?></strong>
                    <span style="color:#000000"><?= $value->stamp->name ?></span>
                  </p>
                  <img src="admin/images/stamp/<?= $value->stamp->image?>" alt="оснастка" style="padding:0px; height:150px">
                  <p style="margin-top:5px">
                    <strong class="text-center" style="color:#3B5998; font-size:18px"><span class="price"><?= $value->stamp->stamp_price->price + ClicheHelper::getPrice() ?></span> р.</strong>
                  </p>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>

          <?php if ($dataCount == 1): ?>
              <?php for ($i=0; $i < 3; $i++):  ?>
                <?php $info_array[] = $value->stamp->info; ?>
                <div data-id="<?= $value->stamp->id?>">
                  <div class="row stamp">
                    <p class="text-left" style="margin:0 0 0 10px">
                      <strong ># <?= $value->stamp->id ?></strong>
                      <span style="color:#000000"><?= $value->stamp->name ?></span>
                    </p>
                    <img src="admin/images/stamp/<?= $value->stamp->image?>" alt="оснастка" style="padding:0px; height:150px">
                    <p style="margin-top:5px">
                      <strong class="text-center" style="color:#3B5998; font-size:18px"><span class="price"><?= $value->stamp->stamp_price->price + ClicheHelper::getPrice() ?></span> р.</strong>
                    </p>
                  </div>
                </div>
              <?php endfor; ?>
          <?php endif; ?>
      </div>
      <div class="row">
        <div class="col-xs-6 col-sm-3 col-md-4 col-lg-3" style="margin-top:40px">
          <button class="back-btn pull-left" data-step="<?= Yii::$app->session['step'] - 1?>">НАЗАД</button>
        </div>
        <div id="info" class="create-info hidden-xs col-sm-6 col-md-4 col-lg-6 text-center" style="margin-top:30px">
          <?php foreach ($info_array as $key => $value): ?>
            <?php if ($key == 1): ?>
              <span id="<?=$key?>" class="item"><?= $value?></span>
            <?php else: ?>
              <span id="<?=$key?>" class="item hidden"><?= $value?></span>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-4 col-lg-3" style="margin-top:40px">
          <button class="step5 next-btn pull-right" >ДАЛЕЕ</button>
        </div>
      </div>
    </div>
  </div>
</div>

