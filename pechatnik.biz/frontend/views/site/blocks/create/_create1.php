
<div id="create1">
  <div class="container">
    <div class="row">
      <div class="row">
        <div class="create-title section-title title-black text-center col-xs-12">
          <h1>ЗАКАЗАТЬ ПЕЧАТЬ</h1>
          <h3>1. Выберите тип печати</h3>
        </div>
      </div>
      <div class="slider center">
        <?php foreach ($data as $cliche): ?>
          <?php $info_array[] = $cliche->info; ?>
          <div data-id="<?= $cliche->id?>">
            <div class="stamp">
              <p class="text-left" style="margin:20px 0 0 10px">

              </p>
              <img src="admin/images/cliche/<?= $cliche->image?>" alt="печать" style="padding:0px; height:150px">
              <p class="bottom" style="margin-top:5px;"><strong><?= $cliche->name ?></strong></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="row">
        <div class="col-xs-6 col-sm-3 col-md-4 col-lg-3" style="margin-top:40px">

        </div>
        <div id="info" class="create-info hidden-xs col-sm-6 col-md-4 col-lg-6 text-center" style="margin-top:30px; height:80px">
          <?php foreach ($info_array as $key => $value): ?>
            <?php if ($key == 1): ?>
              <span id="<?=$key?>" class="item"><?= $value?></span>
            <?php else: ?>
              <span id="<?=$key?>" class="item hidden"><?= $value?></span>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-4 col-lg-3" style="margin-top:40px">
          <button class="step2 next-btn pull-right">ДАЛЕЕ</button>
        </div>
      </div>
    </div>
  </div>
</div>
