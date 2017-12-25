<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 03.11.17
 * Time: 23:43
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \common\models\TemplateSettings $model */
/** @var \yii\web\View $this */

\backend\assets\JRangeAsset::register($this);
\backend\assets\SvgArcAsset::register($this);

$this->registerJs('$(\'.slider-radius\').jRange({
    from: 10,
    to: 200,
    step: 0.5,
    format: \'%s\',
    width: 150,
    showLabels: true,
    snap: true,
    onstatechange: initPreview
});');

$this->registerJs('$(\'.slider-angle\').jRange({
    from: -360.0,
    to: 360.0,
    step: 0.5,
    format: \'%s\',
    width: 150,
    isRange: true,
    showLabels: true,
    snap: true,
    onstatechange: initPreview
});');

$this->registerJs('$(\'.slider-x, .slider-y\').jRange({
    from: 0,
    to: 300,
    step: 0.1,
    format: \'%s\',
    width: 150,
    showLabels: true,
    snap: true,
    onstatechange: initPreview
});');

$this->registerJs('$(\'input[name="TemplateSettings[mirror]"], input[name="TemplateSettings[inner]"]\').on(\'change\', function(e) {
    initPreview();
});');

$this->registerJs('$(\'#edit-template\').on(\'submit\', function(e) {
    e.preventDefault();
    
    $.ajax({
        url: $(this).attr(\'action\'),
        method: \'POST\',
        data: $(this).serialize(),
        success: function (response) {
            alert(\'Сохранено\');
        }
    });
});');
?>

<script>
    function initPreview() {
        var templateSelectorArray, templateSelector, templateSelectorMirror, templateSelectorMirror2;

        templateSelectorArray = $('input[name="TemplateSettings[selector]"]').val().split(',');

        if (templateSelectorArray.length > 1) {
            var i = 0;
            templateSelectorArray.forEach(function(value) {
                var cleanedValue = $('#'+value.trim());

                switch (i) {
                    case 0:
                        templateSelector = cleanedValue;
                        break;
                    case 1:
                        templateSelectorMirror = cleanedValue;
                        break;
                    case 2:
                        templateSelectorMirror2 = cleanedValue;
                        break;
                }

                ++i;
            });

        }
        else {
            templateSelector = $('#'+templateSelectorArray[0].trim());
        }

        var x = $('input[name="TemplateSettings[x]"]').val();
        var y = $('input[name="TemplateSettings[y]"]').val();
        var inner = $('input[name="TemplateSettings[inner]"]').is(':checked');
        var mirror = $('input[name="TemplateSettings[mirror]"]').is(':checked');
        var mirror2 = $('input[name="TemplateSettings[mirror2]"]').is(':checked');

        var angles = $('input[name="TemplateSettings[angles]"]').val().split(',');
        var anglesMirror = $('input[name="TemplateSettings[angles_mirror]"]').val().split(',');
        var anglesMirror2 = $('input[name="TemplateSettings[angles_mirror2]"]').val().split(',');

        $('#test-field').off('keyup').on('keyup', initPreview);
        templateSelector.attr('transform', 'translate('+x+','+y+')');
        templateSelector.svgarc($('input[name="TemplateSettings[prefix]"]').val()+' '+$('#test-field').val(), $('input[name="TemplateSettings[radius]"]').val(), angles[0], angles[1], inner);

        if (mirror && templateSelectorMirror) {
            templateSelectorMirror.attr('transform', 'translate('+(x+50)+','+y+')');
            templateSelectorMirror.svgarc($('input[name="TemplateSettings[prefix]"]').val()+' '+$('#test-field').val(), $('input[name="TemplateSettings[radius_mirror]"]').val(), anglesMirror[0], anglesMirror[1], true);
        }

        if (mirror2 && templateSelectorMirror2) {
            templateSelectorMirror2.attr('transform', 'translate('+(x+50)+','+y+')');
            templateSelectorMirror2.svgarc($('input[name="TemplateSettings[prefix]"]').val()+' '+$('#test-field').val(), $('input[name="TemplateSettings[radius_mirror2]"]').val(), anglesMirror2[0], anglesMirror2[1], true);
        }
    }
</script>

<div class="col-md-12">
    <h3>Заполняется поле - <?php echo $model->field ?></h3>
    <?php $form = ActiveForm::begin([
        'id'=>'edit-template',
        'action' => '/admin/cliche-tpl/edit-template/'.$model->template_id.'/'.$model->field,
        'fieldConfig' => [
            'template' => "<div class='row'><div class='col-md-4'>{label}{hint}\n{error}</div><div class='col-md-8'>{input}</div></div>"
        ]
    ]); ?>
    <?php $mirror = $model->mirror; ?>
    <?php $inner = $model->inner; ?>

    <div class="col-md-6">
    <?php echo $form->field($model, 'radius')->hiddenInput(['class'=>'slider-radius']); ?>
    <?php echo $form->field($model, 'radius_mirror')->hiddenInput(['class'=>'slider-radius']); ?>
    <?php echo $form->field($model, 'radius_mirror2')->hiddenInput(['class'=>'slider-radius']); ?>
    <?php echo $form->field($model, 'angles')->hiddenInput(['class'=>'slider-angle']); ?>
    <?php echo $form->field($model, 'angles_mirror')->hiddenInput(['class'=>'slider-angle']); ?>
    <?php echo $form->field($model, 'angles_mirror2')->hiddenInput(['class'=>'slider-angle']); ?>
    </div>
    <div class="col-md-6">
    <div class='row'><div class='col-md-4'>Пробный текст</div><div class='col-md-8'><?php echo Html::input('text', null, 'Testing', ['class'=>'form-control', 'id'=>'test-field']) ?></div></div>
    <?php echo $form->field($model, 'selector')->textInput(['class'=>'form-control']); ?>
    <?php echo $form->field($model, 'x')->hiddenInput(['class'=>'slider-x']); ?>
    <?php echo $form->field($model, 'y')->hiddenInput(['class'=>'slider-y']); ?>
    <?php echo $form->field($model, 'prefix')->textInput(['class'=>'form-control']); ?>
    <?php echo $form->field($model, 'inner')->checkbox(); ?>
    <?php echo $form->field($model, 'mirror')->checkbox(); ?>
    <?php echo $form->field($model, 'mirror2')->checkbox(); ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="row">
        <div class="col-md-12 btn-group">
            <?php echo Html::button('Сохранить', ['class'=>'btn btn-success', 'onclick'=>'$(\'#edit-template\').submit(); return false;']); ?>
            <?php echo Html::button('Обновить макет', ['class'=>'btn btn-primary', 'onclick'=>'initPreview()']); ?>
        </div>
    </div>
</div>
