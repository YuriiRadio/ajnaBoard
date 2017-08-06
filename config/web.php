<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'uk-UA',
    'defaultRoute' => 'article-category/',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'layout' => 'admin_layout',
            //'defaultRoute' => 'default/index',
        ],
        'user' => [
            'class' => 'app\modules\user\Module',
            //'layout' => 'user_layout',
            'defaultRoute' => 'user/index',
        ]
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'IsOTAQTs3-JbWdOh7RuUuCBWPMZLoS6w',
            'baseUrl' => '',
            // Компонент для мови
            'class' => 'app\components\LanguageRequest'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            //'loginUrl' => 'controller/action'
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            // Компонент для мови
            'class' => 'app\components\LanguageUrlManager',
            'rules' => [
                #site/static
                'site/static/<alias:>' => 'site/static',
                #article-categories
                'article-category/<id:\d+>/page/<page:\d+>' => 'article-category/view',
                'article-category/<id:\d+>' => 'article-category/view',
                #articles
                'article/page/<page:\d+>' => 'article/index',
                'article/<id:\d+>' => 'article/view',
                #advert-categories
                'advert-category/<id:\d+>/page/<page:\d+>' => 'advert-category/view',
                'advert-category/<id:\d+>' => 'advert-category/view',
                #adverts
                'advert/page/<page:\d+>' => 'advert/index',
                'advert/<id:\d+>' => 'advert/view',
            ],
        ],
        'setting'=> [
            'class' => 'app\components\SettingComponent',
            'cache' => 60,
        ],
    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\PathController',
            'as access' => [
                'class' => yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->isAdmin();
                        }
                    ],
                ],
            ],
            'root' => [
                'baseUrl'=>'/web',
                //'basePath'=>'@webroot',
                'path' => 'uploads',
                'name' => 'Uploads'
            ],
//            'watermark' => [
//                        'source'         => __DIR__.'/logo.png', // Path to Water mark image
//                         'marginRight'    => 5,          // Margin right pixel
//                         'marginBottom'   => 5,          // Margin bottom pixel
//                         'quality'        => 95,         // JPEG image save quality
//                         'transparency'   => 70,         // Water mark image transparency ( other than PNG )
//                         'targetType'     => IMG_GIF|IMG_JPG|IMG_PNG|IMG_WBMP, // Target image formats ( bit-field )
//                         'targetMinPixel' => 200         // Target image minimum pixel size
//            ]
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
