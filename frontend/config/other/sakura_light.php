<?php

use yii\web\Request;


return [
    'components' => [
        'view' => [
            'theme' => [
                'class'=>'extended\view\Theme',
                'id'=>'sakura_light',
                'pathMap' => [
                    '@app/views' => '@themes/sakura_light',
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => (YII_ENV_PROD||YII_ENV_TEST) ? require __DIR__.'/../assets/assets-sakura-light.php':[],
        ],
    ],
];

