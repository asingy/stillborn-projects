<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
            'cookieValidationKey' => env('COOKIE_VALIDATION_KEY')
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'contact'=>'site/contact',
                'create'=>'site/create',
                'get_delivery'=>'site/get_delivery',
                'get-template/<id>/<size>'=>'site/get-template',
                'new_order'=>'site/new_order',
                'order'=>'site/order',
                'message'=>'site/message',
                'yakassa'=>'site/yakassa',
                '<slug>'=>'site/page',
            ],
        ],
        'yakassa' => [
            'class' => 'kroshilin\yakassa\YaKassa',
            'paymentAction' => YANDEX_DEMO ? 'https://demomoney.yandex.ru/eshop.xml' : 'https://money.yandex.ru/eshop.xml',
            'shopPassword' => env('YANDEX_SHOP_PASSWORD'),
            'securityType' => 'MD5',
            'shopId' => env('YANDEX_SHOP_ID'),
            'scId' => env('YANDEX_SC_ID')
        ]

    ],
    'params' => $params,
];
