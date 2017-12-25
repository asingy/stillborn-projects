<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login') {
/**
 * Do not use this code in your template. Remove it.
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

  Yii::$app->view->registerJs('
    yii.confirm = function(message, ok, cancel) {
        bootbox.setDefaults({
            locale: "ru",animate: false,
        });
        bootbox.confirm({
            size: "small",
            message : message,
            className: "modal-danger",
            buttons: {
                confirm: {
                  label: "Да",
                  className: "btn-flat btn-outline",
                  callback: function() {},
                },
                cancel: {
                  label: "Нет",
                  className: "btn-flat btn-outline",
                  callback: function() {},
                },
            },
            callback: function(result) {
                if (result) { !ok || ok(); } else { !cancel || cancel(); }
            },
        });
    }
');

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    // dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode(Yii::$app->name.' - '.$this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>0.1</b>
            </div>
            <strong>Печатник</strong>
        </footer>
    </div>
    <?php foreach (Yii::$app->session->getAllFlashes() as $message): ?>
        <?= kartik\growl\Growl::widget([
            'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
            'title' => (!empty($message['title'])) ? $message['title'] : '',
            'icon' => (!empty($message['icon'])) ? $message['icon'] : 'glyphicon glyphicon-info-sign',
            'body' => (!empty($message['message'])) ? $message['message'] : 'Message Not Set!',
            'showSeparator' => true,
            'delay' => 1,
            // 'bodyOptions' => ['style'=>'padding: 0 10px;'],
            'iconOptions' => ['style'=>'margin-right: 10px'],
            'pluginOptions' => [
                'delay' => (!empty($message['duration'])) ? $message['duration'] : 4000,
                'placement' => [
                    'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                    'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'center',
                ]
            ]
        ]) ?>
    <?php endforeach; ?>
    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
