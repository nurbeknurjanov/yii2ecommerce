<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'product'=>'log',//zaglushka
        'order'=>'log',
        'article'=>'log',
        'comment'=>'log',
        'file'=>'log',
        'tag'=>'log',
        'eav'=>'log',
    ],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    //'levels' => ['error', 'warning'],
                    'categories' => [ //the list of categories, you you leave there empty array, it will log all categories
                        //'application',// yii errors
                        'yii\db*',//sql errors
                        //'yii\*',//all yii errors
                        //'blockProfile'//here is a problem
                    ],
                    'except'=>[//list of categories you want to ignore, not to log
                        //'yii\db*',
                    ],
                    /*'prefix' => function ($message) {
                            if(Yii::$app->user->identity)
                                return Yii::$app->user->identity->id;
                            return 'Guest';
                        },*/
                    'logFile' => '@runtime/app.log',
                    'enabled'=>false,
                ],

            ],
        ],
    ],
    'params' => $params,
];
