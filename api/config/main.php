<?php

use yii\web\Request;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php')
);


return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    /*'on '. \yii\web\Application::EVENT_BEFORE_ACTION => function(\yii\base\Event $event){
                if(Yii::$app->controller->action->id=='error')
                    return true;
                return (new \yii\filters\RateLimiter())->beforeAction(Yii::$app->controller->action);
            },
    'on '. \yii\web\Application::EVENT_BEFORE_ACTION => function(\yii\base\Event $event){
            if(Yii::$app->controller->action->id=='error')
                return true;
            return (new \common\components\RejectIP())->beforeAction(Yii::$app->controller->action);
        },*/
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@api/runtime/app.log',
                    'enabled'=>false,
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'user\models\User',
            'enableAutoLogin' => false,
            'enableSession'=>false,
            'loginUrl'=>null,
        ],
        'errorHandler' => [
            'class' => 'api\components\ErrorHandler',
            'errorAction' => 'site/error',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'someKey',
            'enableCsrfValidation'=>false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'baseUrl'=>str_replace('/api/web', '', (new Request)->baseUrl),
            //'baseUrl'=>str_replace('/web', '', (new Request)->baseUrl),
        ],
        'urlManager' => [
            'baseUrl'=>str_replace('/api/web', '', (new Request)->baseUrl).'#',
            //'baseUrl'=>str_replace('/web', '', (new Request)->baseUrl),
            'class' => 'api\components\UrlManager',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => ['phase', 'page']],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/phase']],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v2/phase']],
            ],
        ],
        'response'=>[
            'on beforeSend'=>function ($event) {
                $response = $event->sender;

                $data = $response->data;
                $response->data = null;

                $response->data['statusCode'] = $response->statusCode;
                $response->data['statusMessage'] = $response->statusText;
                if($data)
                    $response->data['data'] =  $data;
                //print_r($response->data); die();
                //$response->data = serialize($response->data);

                if(isset($_GET['format']))
                    $response->format = $_GET['format'];

                return $response->data;
            },
            'format'=>\yii\web\Response::FORMAT_JSON,
            //'format'=>\yii\web\Response::FORMAT_XML,
            //'format'=>\yii\web\Response::FORMAT_RAW,
        ],
    ],
    'modules' => [
        'v1' => [
            'class' => 'api\modules\v1\Module',
            /*'on '. \yii\web\Application::EVENT_BEFORE_ACTION => function(\yii\base\Event $event){
                if(Yii::$app->controller->action->id=='error')
                    return true;
                return (new \yii\filters\RateLimiter())->beforeAction(Yii::$app->controller->action);
            },*/
        ],
        'v2' => [
            'class' => 'api\modules\v2\Module',
        ],
    ],
    'params' => $params,

];