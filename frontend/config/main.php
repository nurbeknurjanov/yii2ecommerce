<?php

use yii\web\Request;
use \yii\i18n\MessageSource;
use extended\i18n\MissingTranslationEventHandler AS MTEH;
use yii\i18n\PhpMessageSource;
use yii\i18n\DbMessageSource;
use i18n\models\I18nSourceMessage;
use i18n\models\I18nMessage;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    //'defaultRoute'=> '/product',
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'setting'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'user\models\User',
            'enableAutoLogin' => true,// it uses cookie login
            'authTimeout' => 3600*24*7,// it means the session authorization
            'loginUrl'=>['/user/guest/login'],
            'identityCookie' => [
                'name' => '_frontendUserCookie', // unique for backend
                //'path' => '/frontend_cookie_dir', // correct path for backend app. /
                //'domain' => 'sakura.com',
            ]
        ],
        'session' => [
            'name' => '_frontendSessionId',
            //'savePath' => __DIR__ . '/../runtime/sessions',
            //'cookieParams' => ['domain' => 'sakura.com'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'baseUrl' => str_replace('/frontend/web', '', (new Request)->baseUrl),
            'csrfParam' => '_frontendCSRF',
        ],
        'urlManager' => [
            'baseUrl'=>str_replace('/frontend/web', '', (new Request)->baseUrl),
        ],
        'view' => [
            'theme' => [
                'class'=>'extended\view\Theme',
                'id'=>'sakura',
                //'baseUrl'=>str_replace('/frontend/web', '', (new Request)->baseUrl).'/themes/sakura',// не знаю для чего это
                'pathMap' => [
                    '@app/views' => '@themes/sakura',
                    //'@product/views' => '@themes/sakura',
                    //'@themes/sakura/product/views' => '@themes/sakura',
                ],
            ],
        ],
        'assetManager' => [
            //this mode determines, if production or testing, then it includes only compressed files
            'bundles' => (YII_ENV_PROD||YII_ENV_TEST) ? (!isset($_COOKIE['theme']) || $_COOKIE['theme']=='sakura' ? require 'assets/assets-sakura.php':[]):[] ,

            //this includes only compressed all.js and all.css files
            //'bundles' => !isset($_COOKIE['theme']) || $_COOKIE['theme']=='sakura' ? require 'assets/assets-sakura.php':[] ,

            //this includes all assets files
            //'bundles' => [] ,
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                //https://developers.facebook.com/apps/
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '',
                    'clientSecret' => '',
                    //'authUrl' => 'https://www.facebook.com/dialog/oauth?display=popup',
                    //'scope'=>'user_photos'
                    //'scope'=>'email'
                    'attributeNames'=>['email', 'name', 'birthday', 'gender', 'first_name', 'last_name', 'locale', 'link', 'location', 'picture.type(large)', ],
                    //'fields'=>'email,name,birthday,gender,first_name,last_name,locale,link,location,albums.limit(5){name, photos.limit(2){name, picture, tags.limit(2)}},posts.limit(5)',
                ],
                //https://console.developers.google.com/
                //https://console.developers.google.com/project/tidy-outlet-106516/apiui/credential/oauthclient/634077512000-g0jci99968hevgebbl2pgtqadkb3dg4f.apps.googleusercontent.com
                'google'=>[
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '',//new
                    'clientSecret' => '',
                    'scope'=>'profile email',
                    'returnUrl' => "",
                    //'scope'=>'https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.login',
                ],
                //https://vk.com/apps?act=manage
                'vkontakte' => [
                    //'class' => 'yii\authclient\clients\VKontakte',
                    'class' => 'extended\authclient\VKontakte',
                    'clientId' => '',
                    'clientSecret' => '',
                ],
            ],
        ],

    ],
    /*'modules'=>[
        'social' => [
            // the module class
            'class' => 'kartik\social\Module',

            'disqus' => [
                'settings' => ['shortname' => 'DISQUS_SHORTNAME'] // default settings
            ],

            // the global settings for the facebook widget
            'facebook' => [
                'appId' => '1492252481090244',
                'secret' => 'bc474b6f7c76b1de1bf3697659861eaa',
            ],
        ],
    ],*/
    'params' => $params,
];