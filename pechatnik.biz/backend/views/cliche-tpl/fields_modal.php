<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\helpers\ClicheHelper;
use yii\widgets\Pjax;

/** @var $this \yii\web\View */

$this->registerJS("$('.add').on('click', function(){
  $.ajax({
     url: '".Url::to(['/cliche-tpl/fields', 'id'=>$model->id])."',
     type: 'POST',
     data: {'field':$('.param').val()},
     success: function(data) {
              $('#fields').html(data);
     }
  });
});

");

$this->registerJS("$('#fields').on('click', '.delete', function(){
  $.ajax({
     url: '".Url::to(['/cliche-tpl/delete_field', 'id'=>$model->id])."',
     type: 'POST',
     data: {'field':$(this).data('field')},
     success: function(data) {
              $('#fields').html(data);
     }
  });
});

");

?>

<script>
  var editor = $('#editor-viewport'),
      layers = $('#editor-layer');

  $('.edit-field').on('click', function(e) {
      e.preventDefault();

      $(editor).trigger('editFieldLoad', [{'id': $(this).data('id'), 'field': $(this).data('field')}]);
  });

  $(editor).on('editorReload', function(e, data) {
    var id = null;

    if (typeof data.id !== 'undefined') {
      id = data.id;
    }
    else {
      id = editor.data('id');
    }

    if (id !== null) {
      $.ajax({
        url: '/admin/cliche-tpl/get-template?id=' + id,
        method: 'GET',
        success: function (response) {
          var template = response.template;
          editor.html(template);
        }
      });
    }
  });

  $(editor).on('editFieldLoad', function(e, data) {
    var id = null;

    if (typeof data.id !== 'undefined' && typeof data.field !== 'undefined') {
      $.ajax({
        url: '/admin/cliche-tpl/edit-template/' + data.id + '/' + data.field,
        method: 'GET',
        success: function (response) {
          var template = response.template;
          layers.html(template);
        }
      });
    }
  });
</script>

<div class="modal-dialog modal-xl">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">
        Добавление полей к макету
      </h4>
    </div>
    <div class="modal-body">
      <div class="input-group">
        <?= Html::dropDownList('field', '', $list, ['class' => 'param form-control']); ?>
        <div class="input-group-btn">
          <?= Html::button('<i class="fa fa-plus"></i>', ['class' => 'add pull-right btn-flat btn btn-primary']) ?>
        </div>
      </div>
        <br>
        <div class="box box-primary">
          <div class="row">
            <div class="col-md-7">
              <div class="box-header with-border">
                <h4 class="box-title">Редактор</h4>
              </div>
              <div class="box-body" id="editor-viewport" data-id="<?php echo $model->id ?>"></div>
              <div class="row" id="editor-layer"></div>
            </div>
            <div class="col-md-4">
              <div class="box-header with-border">
                <h4 class="box-title">Список полей</h4>
              </div>
              <div class="box-body">

                <div id="fields">
                  <?php if($fields === ''): ?>
                    <p>Поля не определены</p>
                  <?php else: ?>
                    <?php foreach ($fields as $key => $value): ?>
                      <p>
                        <?= $value->name ?>
                        <?= Html::button('<i class="glyphicon glyphicon-trash"></i>', ['class' => 'delete btn btn-xs btn-flat btn-danger pull-right', 'data-field'=>$value->field]); ?>
                        <?= Html::button('<i class="glyphicon glyphicon-edit"></i>', ['class' => 'edit-field btn btn-xs btn-flat btn-primary pull-right', 'data-id'=>$model->id, 'data-field'=>$value->field]); ?>
                      </p>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>

              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
