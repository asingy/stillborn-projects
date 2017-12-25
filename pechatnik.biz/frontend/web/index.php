<?php
ini_set("error_reporting", "Off");

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../helpers/dotenv.php');

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../../');
$dotenv->load();

defined('YII_DEBUG') or define('YII_DEBUG', env('YII_DEBUG'));
defined('YANDEX_DEMO') or define('YANDEX_DEMO', env('YANDEX_DEMO'));
defined('YII_ENV') or define('YII_ENV', env('YII_ENV'));

require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../config/main.php')
);

(new yii\web\Application($config))->run();
