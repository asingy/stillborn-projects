<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/** @var $this \yii\web\View */

\backend\assets\SvgArcAsset::register($this);

$this->registerJs('$(\'.edit-field\').click(function() {
  $.ajax({
    url: \'/get-template-form/'.$data['id'].'/\' + $(this).data(\'id\'),
    method: \'GET\',
    success: function(response) {
      $(\'.cliche_control\').html(response);
    }
  });
});');
 ?>
<div id="create3" >
  <div class="container">
    <div class="row">
      <div class="row">
        <div class="create-title section-title title-black text-center col-xs-12">
          <h1>ЗАКАЗАТЬ ПЕЧАТЬ</h1>
          <h3>3. Конструктор печати</h3>
        </div>
      </div>

      <div class="row create_3">
        <div class="col-md-6 text-center" style="padding-left: 0">
          <div class="cliche_template row">
            <div class="col-md-12" id="cliche_image">
              <?= $data['image'] ?>
            </div>
          </div>
          <?php if (!Yii::$app->user->isGuest): ?>
          <div class="cliche_control row">
            
          </div>
          <?php endif; ?>
        </div>
        <div class="col-md-6">
          <?php ActiveForm::begin(['id'=>'form-step3','enableAjaxValidation' => false, 'enableClientValidation' => false]); ?>
          <div class="row constructor-form" style="margin-top:20px">
            <?= Html::hiddenInput('id_cliche_tpl', Yii::$app->session['data_step2'], ['class' => '']); ?>
            <?= Html::hiddenInput('svg', '', ['id' => 'svg_h']); ?>
            <div class="decorate-input">
              <?= Html::dropDownList('size', $data['size'], $data['sizes'], ['class' => 'form-control constructor-select cliche-size', 'required'=>'required']); //, 'prompt'=>'Размер печати'?>
              <i class="zmdi zmdi-chevron-down"></i>
            </div>
            <?php foreach ($data['fields'] as $key => $value): ?>
              <div class="decorate-input">
                <?php $settings = \common\models\TemplateSettings::findByTemplateAndField($data['id'], $value->field);
                      if ($settings): ?>
                <script>
                  $('#<?php echo $value->field ?>').off('keyup').on('keyup', function(e) {
                      e.preventDefault();
                    <?php if ($settings->mirror && !$settings->mirror2 && is_array($settings->getSelector())): ?>
                      $('#<?php echo $settings->getSelector()[0] ?>').attr('transform', 'translate(<?php echo $settings->x ?>,<?php echo $settings->y ?>)').svgarc('<?php echo $settings->prefix ?> '+$(this).val(), <?php echo $settings->radius ?>, <?php echo $settings->start ?>, <?php echo $settings->end ?>, false);
                      $('#<?php echo $settings->getSelector()[1] ?>').attr('transform', 'translate(<?php echo $settings->x ?>,<?php echo $settings->y ?>)').svgarc('<?php echo $settings->prefix ?> '+$(this).val(), <?php echo $settings->radius_mirror ?>, <?php echo $settings->start_mirror ?>, <?php echo $settings->end_mirror ?>, true);
                    <?php elseif ($settings->mirror &&  $settings->mirror2  && is_array($settings->getSelector())): ?>
                    $('#<?php echo $settings->getSelector()[0] ?>').attr('transform', 'translate(<?php echo $settings->x ?>,<?php echo $settings->y ?>)').svgarc('<?php echo $settings->prefix ?> '+$(this).val(), <?php echo $settings->radius ?>, <?php echo $settings->start ?>, <?php echo $settings->end ?>, false);
                    $('#<?php echo $settings->getSelector()[1] ?>').attr('transform', 'translate(<?php echo $settings->x ?>,<?php echo $settings->y ?>)').svgarc('<?php echo $settings->prefix ?> '+$(this).val(), <?php echo $settings->radius_mirror ?>, <?php echo $settings->start_mirror ?>, <?php echo $settings->end_mirror ?>, true);
                    $('#<?php echo $settings->getSelector()[2] ?>').attr('transform', 'translate(<?php echo $settings->x ?>,<?php echo $settings->y ?>)').svgarc('<?php echo $settings->prefix ?> '+$(this).val(), <?php echo $settings->radius_mirror2 ?>, <?php echo $settings->start_mirror2 ?>, <?php echo $settings->end_mirror2 ?>, true);
                    <?php else: ?>
                      $('#<?php echo $settings->getSelector() ?>').attr('transform', 'translate(<?php echo $settings->x ?>,<?php echo $settings->y ?>)').svgarc('<?php echo $settings->prefix ?> '+$(this).val(), <?php echo $settings->radius ?>, <?php echo $settings->start ?>, <?php echo $settings->end ?>, <?php echo $settings->inner ? 'true' : 'false' ?>);
                    <?php endif; ?>
                  });
                </script>
                <?php endif; ?>
                <?= Html::textInput($value->field, isset($value->val) ? $value->val : '', ['id'=>$value->field, 'class' => 'bevalidate constructor-input', 'placeholder'=> $value->name, 'required'=>'required']); ?>
              </div>
            <?php endforeach; ?>
          <?php ActiveForm::end(); ?>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-6 col-sm-3 col-md-4 col-lg-3" style="margin-top:40px">
          <button class="back-btn pull-left" data-step="<?= Yii::$app->session['step'] -1 ?>">НАЗАД</button>
        </div>
        <div class="create-info hidden-xs col-sm-6 col-md-4 col-lg-6 text-center" style="margin-top:30px">
        </div>
        <div class="col-xs-6 col-sm-3 col-md-4 col-lg-3" style="margin-top:40px">
          <button class="step4 next-btn pull-right" >ДАЛЕЕ</button>
        </div>
      </div>
    </div>
  </div>
</div>
