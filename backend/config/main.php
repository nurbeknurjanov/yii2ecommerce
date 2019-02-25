<?php

use yii\web\Request;
use user\models\User;
use yii\web\ForbiddenHttpException;
use yii\web\Application;
use yii\base\Event;
use extended\helpers\Html;
use yii\i18n\PhpMessageSource;
use \yii\i18n\MessageSource;
use extended\i18n\MissingTranslationEventHandler AS MTEH;

Yii::$container->set('yii\grid\GridView', [
    'options'=>['class'=>'grid-view box-body table-responsive'],
    //'options'=>['class'=>'grid-view box-body table-responsive no-padding'],
    'tableOptions'=>['class'=>'table table-bordered'],
    //'tableOptions'=>['class'=>'table table-hover'],
    'summaryOptions'=>['style'=>'margin-left:10px;'],
    //'summary'=>false,
]);

Yii::$container->set(\yii\grid\ActionColumn::class, [
    'buttonOptions'=>['class'=>'btn btn-xs'],
    'buttons'=>[
        'view'=>function ($url, $model, $key){
            $options = [
                'title' => Yii::t('yii', 'View'),
                'aria-label' => Yii::t('yii', 'View'),
                'data-pjax' => '0',
                'class'=>'btn btn-xs btn-default',
            ];
            return Html::a('<span class="fa fa-eye"></span>', $url, $options);
        },
        'update'=>function ($url, $model, $key){
            $options = [
                'title' => Yii::t('yii', 'Update'),
                'aria-label' => Yii::t('yii', 'Update'),
                'data-pjax' => '0',
                'class'=>'btn btn-xs btn-primary',
            ];
            return Html::a('<span class="fa fa-pencil"></span>', $url, $options);
        },
        'delete'=>function ($url, $model, $key){
            $options = [
                'title' => Yii::t('yii', 'Delete'),
                'aria-label' => Yii::t('yii', 'Delete'),
                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'data-method' => 'post',
                'data-pjax' => '0',
                'class'=>'btn btn-xs btn-danger',
            ];
            return Html::a('<span class="fa fa-times"></span>', $url, $options);
        },
    ]
]);



Yii::$container->set('yii\widgets\DetailView', [
    'options'=>['class' => 'table table-striped table-bordered detail-view table-hover'],
    //'options'=>['class'=>'box-body table-responsive no-padding'],
]);

Yii::$container->set('yii\widgets\Breadcrumbs', [
    'options'=>[ 'class'=>'breadcrumb',/*'style'=>'width: 45%',*/],
    'tag'=>'ol',
    'homeLink'=>['label'=>'<i class="fa fa-dashboard"></i> Home', 'url'=>'/', 'encode'=>false,],
]);


$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'user\models\User',
            'enableAutoLogin' => true,// it uses cookie login
            'authTimeout' => 3600*24*7,// it means the session authorization
            'loginUrl'=>['/user/guest/login'],
            'identityCookie' => [
                'name' => '_backendUserCookie', // unique for backend
                //'path' => '/backend_cookie_dir', // correct path for backend app.
                //'domain' => 'backend.sakura.com',
            ]
        ],
        'session' => [
            'name' => '_backendSessionId',
            //'savePath' => __DIR__ . '/../runtime/sessions',
            //'cookieParams' => ['domain' => 'backend.sakura.com'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            //'baseUrl' => str_replace('/backend/web', '', (new Request())->baseUrl),
            'baseUrl' => str_replace('/web', '', (new Request())->baseUrl),
            'csrfParam' => '_backendCSRF',
        ],
        'urlManager' => [
            //'baseUrl'=>str_replace('/backend/web', '', (new Request())->baseUrl),
            'baseUrl'=>str_replace('/web', '', (new Request())->baseUrl),
        ],
        'view' => [
            'theme' => [
                'class'=>'extended\view\Theme',
                'id'=>'adminlte',
                'pathMap' => [
                    '@app/views' => '@themes/adminlte',
                    '@user/views' => '@themes/adminlte',
                ],
            ],
        ],
    ],
    'params' => $params,
    'modules'=>[
        'i18n' => [
            'class' => 'i18n\Module',
        ],
        'rbac' =>  [
            'class' => 'johnitvn\rbacplus\Module',
            'beforeAction'=>function($action){
                if(!Yii::$app->user->can(User::ROLE_MANAGER))
                    throw new ForbiddenHttpException('You are not allowed to access this page.');
                return true;
            },
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
        'user' => [
            'class' => 'user\Module',
            'modules'=>[
                'manage' => [
                    'class' => 'user_manage\Module',
                ],
                'delivery' => [
                    'class' => 'delivery\Module',
                ],
            ],
        ],
    ],
    'bootstrap' => [
        'setting',
        'log',
        'johnitvn\\rbacplus\\Bootstrap',
        'johnitvn\\ajaxcrud\\Bootstrap',
    ],
    'on '.\yii\base\Module::EVENT_BEFORE_ACTION=>function(Event $event){
        /* @var $app Application */
        /* @var $baseModule Application */
        $app = $baseModule = $event->sender;
        if(Yii::$app->user->isGuest)
            $baseModule->controller->layout='//../not_logged_layouts/main';
    },
];
