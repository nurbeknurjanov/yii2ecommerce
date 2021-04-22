<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\ArrayHelper;
use user\models\User;
use yii\helpers\Url;
use order\models\Order;

$themeBundle = \themes\adminlte3\assets\AdminLTEAsset::register($this);
$assetDir = $themeBundle->baseUrl;
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="<?=$assetDir?>/images/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?php
                echo Yii::$app->user->identity->getThumbImg('xs',['class'=>'img-circle elevation-2'], 45);
                ?>
            </div>
            <div class="info">
                <a href="#" class="d-block"><?=Yii::$app->user->identity->fullName?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2 left-menu">

            <?php


            $items = [
                [
                    'label' => Yii::t('common', 'Dashboard'),
                    //'url' => ['/site/index'],
                    'icon' => 'tachometer-alt',
                    'items' => [
                        ['label' => 'Active Page', 'url' => ['site/qwe'],
                            'iconStyle' => 'far',
                            ],
                    ]
                ]
            ];

            if(Yii::$app->user->can('indexOrder')){
                $newOrdersCount = Order::find()->newStatus()->count();
                $newOrdersText = Yii::t('order', '{n, plural, =0{no new orders} =1{# new order} other{# new orders}}', ['n'=>$newOrdersCount]);
                $items[] = [
                    'label' => Yii::t('order', 'Orders'),
                    'encode'=>false,
                    'badge' => "<span class=\"right badge badge-info\">$newOrdersText</span>",
                    'url' => ['/order/order/index'],
                    'icon'=>'inbox',
                ];
            }



            if(Yii::$app->user->can('indexShop'))
                $items[] = ['label' => Yii::t('product', 'Shops'), 'url' => ['/shop/shop/index'], 'icon'=>/*'th-list'*/ 'barcode'];


            if(Yii::$app->user->can('indexProduct'))
                $items[] = ['label' => Yii::t('product', 'Products'), 'url' => ['/product/product/index'], 'icon'=>/*'th-list'*/ 'barcode'];

            if(Yii::$app->user->can('indexCategory'))
                $items[] = ['label' => Yii::t('category', 'Categories'), 'url' => ['/category/category/index'], 'icon'=>'list',];
            if(Yii::$app->user->can(User::ROLE_ADMINISTRATOR))
                $items[] = ['label' => Yii::t('eav', 'Dynamic fields'), 'url' => ['/eav/dynamic-field/index'], 'icon'=>'outdent',];

            if(Yii::$app->user->can('indexUser'))
                $items[] = [
                    'label' => Yii::t('user', 'Users'), 'url' => ['/user/manage/user/index'],'icon'=>'users'
                ];

            if(Yii::$app->user->can(User::ROLE_ADMINISTRATOR)){
                $items[] =  [
                    'label' => 'RBAC',
                    'icon'=>'user-plus',
                    'items'=>[
                        ['label'=>Yii::t('user', 'Roles'), 'icon'=>'user', 'url'=>['/rbac/role/index']],
                        ['label'=>Yii::t('user', 'Permissions'), 'icon'=>'user', 'url'=>['/rbac/permission/index']],
                        ['label'=>Yii::t('user', 'Rules'), 'icon'=>'user', 'url'=>['/rbac/rule/index']],
                        ['label'=>Yii::t('user', 'Assignments'), 'icon'=>'user', 'url'=>['/rbac/assignment/index']],
                    ],
                ];
                $items[] =
                    [
                        'label' => Yii::t('user', 'Mailing of letters') ,
                        //'icon'=>'envelope',
                        'icon'=>'paper-plane',
                        'url'=>['/user/delivery/delivery/index'],
                        'items'=>[
                            [
                                'label'=>Yii::t('user', 'Mailing of letters'),
                                'icon'=>'paper-plane',
                                'url'=>['/user/delivery/delivery/index']],
                            [
                                'label'=>Yii::t('user', 'Mails in cron task'),
                                'icon'=>'paper-plane',
                                'url'=>['/user/delivery/cron-email-message/index']],
                        ],
                    ];
            }

            if(Yii::$app->user->can('indexComment'))
                $items[] = [
                    'label' => Yii::t('comment', 'Comments'),  'url'=>['/comment/comment/index'],
                    'icon'=>'comments'
                ];
            if(Yii::$app->user->can(User::ROLE_ADMINISTRATOR))
                $items[] = [
                    'label' => Yii::t('file', 'Files'),  'url'=>['/file/file-manage/index'],
                    'icon'=>'image'
                ];

            if(Yii::$app->user->can('indexPage'))
                $items[] = ['label' => Yii::t('page', 'Pages'), 'url' => ['/page/page/index'], 'icon'=>'file',];
            if(Yii::$app->user->can('indexArticle'))
                $items[] = ['label' => Yii::t('article', 'Articles'), 'url' => ['/article/article/index'],
                    'icon'=>'newspaper',];
            if(Yii::$app->user->can('indexTag'))
                $items[] = ['label' => Yii::t('tag', 'Tags'), 'url' => ['/tag/tag/index'], 'icon'=>'tags',];




            if(Yii::$app->user->can('indexCountry')){
                $items[] = [
                    'label' => Yii::t('country', 'Countries'),
                    'icon'=>'globe',
                    'items'=>[
                        [
                            'label'=>Yii::t('country', 'Countries'),
                            'icon'=>'flag',
                            'url'=>['/country/country/index']
                        ],
                        [
                            'label'=>Yii::t('country', 'States/Provinces'),
                            'icon'=>'flag-checkered',
                            'url'=>['/country/region/index']
                        ],
                        [
                            'label'=>Yii::t('country', 'Cities'),
                            'icon'=>'city',
                            'url'=>['/country/city/index']
                        ],
                    ],
                ];
            }
            if(Yii::$app->user->can(User::ROLE_ADMINISTRATOR)){
                $items[] =                 [
                    'label' => 'I18N',
                    'icon'=>'globe-americas',
                    'items'=>[
                        ['label'=>'Source', 'icon'=>'globe-europe', 'url'=>['/i18n/source/index']],
                        ['label'=>'Messages', 'icon'=>'globe-asia',  'url'=>['/i18n/message/index']]
                    ],
                ];
                $items[] =
                    [
                        'label' => Yii::t('common', 'Console'),
                        'icon'=>'quote-right',
                        'url'=>['/console'],
                    ];
            }

            echo \hail812\adminlte3\widgets\Menu::widget([
                'items' => $items,
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>