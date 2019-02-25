<?php

use yii\web\Request;

return [
    'components' => [
        'view' => [
            'theme' => [
                'class'=>'extended\view\Theme',
                'id'=>'bootstrap',
                'pathMap' => [
                    '@app/views' => '@themes/bootstrap',
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => (YII_ENV_PROD||YII_ENV_TEST) ? require __DIR__.'/../assets/assets-bootstrap.php':[],
        ],
    ],
];

