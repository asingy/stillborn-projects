<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

return [
    'id' => 'app-backend',
    'name' => 'Печатник',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
      'redactor' => 'yii\redactor\RedactorModule',
    ],
    'components' => [
      'assetManager' => [
          'bundles' => [
              'app\assets\AdminLteAsset' => [
                  'skin' => 'skin-red',
              ],
          ],
        ],
        'formatter' => [
           'dateFormat' => 'dd.MM.yyyy',
           'datetimeFormat' => 'dd.MM.yyyy HH:mm',
           'timeZone' => 'UTC',
           'decimalSeparator' => ',',
           'thousandSeparator' => ' ',
           'currencyCode' => '<i class="fa fa-rub"></i>',
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin',
            'cookieValidationKey' => env('COOKIE_VALIDATION_KEY')
        ],
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-common',
            'cookieParams' => ['lifetime' => 7 * 24 *60 * 60]
        ],
        'authManager' => [
            'class' => '\yii\rbac\DbManager',
            'ruleTable' => 'auth_rule',
            'itemTable' => 'auth_item',
            'itemChildTable' => 'auth_item_child',
            'assignmentTable' => 'auth_assignment',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'login'=>'site/login',
                'loguot'=>'site/loguot',
                'cliche-tpl/edit-template/<id>/<field>'=>'cliche-tpl/edit-template',
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
            ],
        ],

    ],
    'params' => $params,
];
