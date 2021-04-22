<?php

use yii\web\Request;
use user\models\User;
use yii\widgets\Pjax;
use kartik\datetime\DateTimePicker;
use kartik\rating\StarRating;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use yii\grid\GridViewAsset;
use \yii\i18n\MessageSource;
use extended\i18n\MissingTranslationEventHandler AS MTEH;
use yii\i18n\PhpMessageSource;
use yii\i18n\DbMessageSource;
use i18n\models\I18nSourceMessage;
use i18n\models\I18nMessage;

//Yii::$container->set('yii\grid\GridView', ['options' => ['class'=>'grid-view table-responsive',]]);
/*Yii::$container->set('yii\bootstrap\BootstrapAsset',[
    'css' => [],
]);*/
/*Yii::$container->set(yii\jui\DatePicker::class,[
    'dateFormat' => 'yyyy-MM-dd',
    'options'=>array('class'=>'col-lg-6',)
]);*/

Yii::$container->set(Pjax::class, [
    'timeout'=>6000,
    //'clientOptions'=>['skipOuterContainers'=>true]
]);
Yii::$container->set(DateTimePicker::class,[
    'options' => ['placeholder' => 'Select time'],
    'convertFormat' => true,
    'pluginOptions' => [
        'format' => 'yyyy-MM-dd H:i',
        'todayHighlight' => true
    ],
]);

Yii::$container->set(StarRating::class,[
    'pluginOptions' => [
        //'showClear'=>(boolean) $rating,
        'showClear'=>true,
        'size'=>'xs',
        'step' => 1,
        'showCaption' => false,
        'displayOnly' => true,
        //'rtl' => true,
    ],
]);
Yii::$container->set(FileInput::class,[
    'pluginOptions'=>[
        'browseClass'=>'btn btn-success',
        'dropZoneEnabled'=>false
    ],
]);
Yii::$container->set(GridViewAsset::class,[
    'sourcePath'=>'@common/bower/gridview',
    'js' => [ 'gridview.js'],
]);


$frontendBaseUrl = str_replace('/frontend/web', '', (new Request)->baseUrl);
$frontendBaseUrl = str_replace('/backend/web', '', $frontendBaseUrl);
//$frontendBaseUrl = str_replace('/web', '', $frontendBaseUrl);

$frontendHostInfo = (new Request)->hostInfo;
$frontendHostInfo = str_replace('backend.', '', $frontendHostInfo);
$frontendHostInfo = str_replace('api.', '', $frontendHostInfo);

if(isset($_SERVER['HTTP_ORIGIN']))
    $frontendHostInfo = $_SERVER['HTTP_ORIGIN'];

$imgHostInfo = (new Request)->hostInfo;
$imgHostInfo = str_replace('backend.', '', $imgHostInfo);
$imgHostInfo = str_replace('demo.', '', $imgHostInfo);
$imgHostInfo = str_replace('api.', '', $imgHostInfo);
if(strpos($imgHostInfo, 'img.')===false)
    $imgHostInfo = str_replace('://', '://img.', $imgHostInfo);

$backendBaseUrl = str_replace('/frontend/web', '', (new Request)->baseUrl);
$backendBaseUrl = str_replace('/backend/web', '', $backendBaseUrl);

$apiBaseUrl = str_replace('/frontend/web', '', (new Request)->baseUrl);
$apiBaseUrl = str_replace('/backend/web', '', $apiBaseUrl);

$backendHostInfo = (new Request)->hostInfo;
$backendHostInfo = str_replace('api.', '', $backendHostInfo);
if(strpos($backendHostInfo, 'backend')===false)
    $backendHostInfo = str_replace('://', '://backend.', $backendHostInfo);

$apiHostInfo = (new Request)->hostInfo;
$apiHostInfo = str_replace('backend.', '', $apiHostInfo);
if(strpos($apiHostInfo, 'api')===false)
    $apiHostInfo = str_replace('://', '://api.', $apiHostInfo);

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'name'=>'SakuraCommerce',
    'language'=>'en-US',
    'timezone' => 'America/New_York',
    'container' => [
        'definitions' => [
            'cookie'=>[
                'class'=>\yii\web\Cookie::class,
                'expire' => time() + 3600*24*7,
                //'domain' => '.sakuracommerce.com'
            ],
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath'=>'@console/runtime/cache',
            //'class' => 'yii\caching\DummyCache',
        ],
        'foo'=>[
            'class' => 'frontend\controllers\Foo',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=sakura',
            'username' => 'sakura',
            'password' => '123123',
            'charset' => 'utf8',
        ],
        'dbCountries' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=countries',
            'username' => 'sakura',
            'password' => '123123',
            'charset' => 'utf8',
        ],
        
        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'enablePrettyUrl'=>true,
            'showScriptName'=>false,
            'enableLanguageDetection'=>false,
            'languages' => ['en-US', 'ru'],
            'rules'=>[
                [
                    'class' => \shop\url_rules\ShopUrlRule::class,
                ]
                //'index.html/<controller>/<action>'=>'<controller>/<action>'
                //'contact-us'=>'site/contact',
                //'<controller:(site)>/<view:(features|pricing)>'=>'<controller>/page',
                //'keyword1/<controller>'=>'<controller>',
                //'keyword1/<controller>/<action>'=>'<controller>/<action>',
                /*[
                    'class' => 'common\components\CommonUrlRule',
                ],*/
                //'<action:\w+>/<controller:\w+>' => '<controller>/<action>',
                //'<action:(contact)>/someword/<controller:\w+>/<id:\d+>' => '<controller>/<action>',
            ],
        ],
        'urlManagerFrontend'=>[
            'class'=>'yii\web\UrlManager',
            'enablePrettyUrl'=>true,
            'showScriptName'=>false,
            'baseUrl' => $frontendBaseUrl,
            'hostInfo' => $frontendHostInfo,
            'rules'=>[
                //'token/<token>'=>'user/token/run',
            ],
        ],
        'urlManagerImg'=>[
            'class'=>'yii\web\UrlManager',
            'enablePrettyUrl'=>true,
            'showScriptName'=>false,
            'hostInfo' => $imgHostInfo,
        ],
        'urlManagerBackend'=>[
            'class'=>'yii\web\UrlManager',
            'enablePrettyUrl'=>true,
            'showScriptName'=>false,
            'baseUrl' => $backendBaseUrl,
            'hostInfo' => $backendHostInfo,
        ],

        'urlManagerApi' => [
            'class'=>'yii\web\UrlManager',
            'enablePrettyUrl'=>true,
            'showScriptName'=>false,
            'baseUrl' => $apiBaseUrl,
            'hostInfo' => $apiHostInfo,
        ],
        'formatter'=>[
            'class' => 'extended\i18n\Formatter',
            'defaultTimeZone'=>'Asia/Almaty',
            'timeZone'=>'Asia/Almaty',
            'currencyCode' => 'USD',
            //'currencyCode' => 'EUR',
            //'currencyCode' => 'RUB',
            /*'numberFormatterSymbols'=>[
                NumberFormatter::CURRENCY_SYMBOL => '₽',//₸
            ],*/
        ],
        'log' => [
            //'traceLevel' => YII_DEBUG ? 3 : 0,
            'traceLevel' => 3,
            'targets' => [
                [
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['error'],
                    'message' => [
                        'from' => ['log@example.com'],
                        'to' => ['nurbek.nurjanov@mail.ru'],
                        'subject' => 'Errors at example.com',
                    ],
                    'enabled'=>false,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'], //info, trace, profile
                    //'levels' => ['error', 'warning', 'info', 'trace', 'profile'], //info, trace, profile
                    //'levels' => ['profile'], //info, trace, profile
                    'categories' => [ //the list of categories, you you leave there empty array, it will log all categories
                        //'i18n',// yii errors
                        //'application',// yii errors
                        //'yii\db*',//sql errors
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => [User::ROLE_GUEST],
            'cache' => 'cache',
        ],
        'setting' => [
            'class' => 'extended\setting\Setting',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => !YII_ENV_PROD,
            'fileTransportPath'=>'@frontend/runtime/mails',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                //https://www.google.com/settings/security/lesssecureapps
                //https://accounts.google.com/b/0/DisplayUnlockCaptcha
                /*'host' => 'mail.smtp2go.com',
                'username' => 'livecom@billang.com',
                'password' => 'bXVnaGF3c3BhZzAw',
                'port' => 587,
                'encryption' => 'tls',*/
                'host' => 'smtp.gmail.com',
                'username' => 'gomer.simpson.developer',
                'password' => '3@Rz%V3Gy"t^ctuS1',
                //'port' => 587,
                'port' => 465,
                //'encryption' => 'tls',
                'encryption' => 'ssl',
            ],
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6LcF4p8UAAAAAOmoJnF1JDSeXN5tkBJ870flNRGF',
            'secret' => '6LcF4p8UAAAAAJFSoikpVAG0gF_18NU7HiNY1npD',
            //https://www.google.com/recaptcha/admin#createsite
        ],
        'assetManager' => [
            'bundles' => [
                /*'yii\bootstrap\BootstrapAsset'=>[
                    'css' => [],
                ]*/
                /*'yii\web\JqueryAsset' => [
                    'js' => [YII_DEBUG ? 'https://code.jquery.com/jquery-3.3.1.js' : 'https://code.jquery.com/jquery-3.3.1.min.js'],
                ],*/
            ],
            'forceCopy'=>YII_ENV_DEV,
        ],
        'view' => [
            'class'=>'extended\view\View',
        ],
        'i18n'=>[
            'translations' =>[
                'common*' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@common/messages',
                    'forceTranslation'=>true,
                    'on '.MessageSource::EVENT_MISSING_TRANSLATION =>
                        [(new MTEH(['sendEmail'=>false, 'warningLog'=>false])), 'handleMissingTranslation'],
                ],
                'backend*' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@backend/messages',
                    'forceTranslation'=>true,
                    'on '.MessageSource::EVENT_MISSING_TRANSLATION =>
                        [(new MTEH(['sendEmail'=>false, 'warningLog'=>false])), 'handleMissingTranslation'],
                ],
                'frontend*' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@frontend/messages',
                    'forceTranslation'=>true,
                    'on '.MessageSource::EVENT_MISSING_TRANSLATION =>
                        [(new MTEH(['sendEmail'=>false, 'warningLog'=>false])), 'handleMissingTranslation'],
                ],
                'db*' => [
                    'class' => DbMessageSource::class,
                    'sourceMessageTable'=>I18nSourceMessage::tableName(),
                    'messageTable'=>I18nMessage::tableName(),
                    'enableCaching' => true,
                    'cachingDuration' => 1000000,
                    'on '.MessageSource::EVENT_MISSING_TRANSLATION =>
                        [(new MTEH(['sendEmail'=>false,'warningLog'=>true,'automaticallyCreateNewRecord'=>true])), 'handleMissingTranslation'],
                ],
            ]
        ],
    ],

    'controllerMap' => [
        /*'nurbek' => [
            'class' => 'frontend\controllers\AidaController',
        ],*/
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' =>[
                [
                    'baseUrl'=>$frontendHostInfo,
                    'basePath'=>Yii::getAlias('@frontend').'/web',
                    'path' => 'editor_upload',
                    'name' => 'Editor files'
                ],
                /*[
                    'class' => 'mihaildev\elfinder\UserPath',
                    'path'  => 'files/user_{id}',
                    'name'  => 'My Documents'
                ],
                [
                    'path'   => 'files/some',
                    'name'   => ['category' => 'my','message' => 'Some Name'], // Yii::t($category, $message)
                    'access' => ['read' => '*', 'write' => 'UserFilesAccess'] // * - для всех, иначе проверка доступа в даааном примере все могут видет а редактировать могут пользователи только с правами UserFilesAccess
                ]*/
            ],
        ]
    ],
    'modules' => [
        'user' => [
            'class' => 'user\Module',
        ],
        'file' => [
            'class' => 'file\Module',
        ],
        'product' => [
            'class' => 'product\Module',
        ],
        'category' => [
            'class' => 'category\Module',
            //route must be call as /category/aida
            'controllerMap' => [
                //'category' => 'filters\category\controllers\CategoryController',
            ],
        ],
        'order' => [
            'class' => 'order\Module',
        ],
        'mii' => [
            'class' => 'mii\Module',
        ],
        'eav' => [
            'class' => 'eav\Module',
        ],
        'favorite' => [
            'class' => 'favorite\Module',
        ],
        'page' => [
            'class' => 'page\Module',
        ],
        'article' => [
            'class' => 'article\Module',
        ],
        'comment' => [
            'class' => 'comment\Module',
        ],
        'tag' => [
            'class' => 'tag\Module',
        ],
        'country' => [
            'class' => 'country\Module',
        ],
        'like' => [
            'class' => 'like\Module',
        ],
        'shop' => [
            'class' => 'shop\Module',
        ],
    ],
    'bootstrap' => [
        'user'=>\user\Bootstrap::class,
        'file'=>\file\Bootstrap::class,
        'order'=>\order\Bootstrap::class,
        'favorite'=>\favorite\Bootstrap::class,
        'article'=>\article\Bootstrap::class,
        'comment'=>\comment\Bootstrap::class,
        'like'=>\like\Bootstrap::class,
        'product'=>\product\Bootstrap::class,
        'category'=>\category\Bootstrap::class,
        'page'=>\page\Bootstrap::class,
        'tag'=>\tag\Bootstrap::class,
        'eav'=>\eav\Bootstrap::class,
        'country'=>\country\Bootstrap::class,
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
];
