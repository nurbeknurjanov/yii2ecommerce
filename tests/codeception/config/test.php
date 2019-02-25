<?php
use yii\base\Event;
use yii\web\Application;

return [
    'id'=>'app-frontend-test',
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../../../frontend/web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'mailer' => [
            //'class' => 'Codeception\Lib\Connector\Yii2\TestMailer',
            'fileTransportPath'=>'@frontend/web/assets/mails',
        ],
        'db' =>
            YII_ENV_TEST_PROD ?
                [
                    'dsn' => 'mysql:host=localhost;dbname=sakura_db_test',
                ]:
                [
                    'dsn' => 'mysql:host=localhost;dbname=sakura_test',
                ],
    ],
    'on '.\yii\base\Module::EVENT_BEFORE_ACTION=>function(Event $event){
        /* @var $app Application */
        /* @var $baseModule Application */
        $app = $baseModule = $event->sender;
        //$baseModule->controller->layout='//../not_logged_layouts/main';
        $dir = Yii::getAlias('@frontend')."/web/assets/mails";
        if(!is_dir($dir))
            mkdir($dir, 0777, true);
    },
];

