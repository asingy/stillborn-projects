<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<style media="screen">
  .status404{
    font-size: 120px;
  }
  .message404 a{
    font-size: 16px;
    color:#3B5998;
  }
</style>
<div class="site-error">

<?php if ($exception->statusCode == '404'): ?>

  <div class="text-center lead" style="margin-top:200px;color:#3B5998">
    <span class="status404">404</span>
      <p class="message404 text-info">Запрашиваемая страница не найдена. <a href="/"><strong>Вернуться на главную</strong></a></p>
  </div>

<?php else: ?>
  <?php $this->redirect(['index']); ?>
<?php endif; ?>

</div>
