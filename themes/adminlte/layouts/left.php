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

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?=Yii::$app->user->identity->img?>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->identity->fullName?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>



        <?=Html::beginForm(['/'], 'get', ['class'=>'sidebar-form'])?>
            <div class="input-group">
                <?=Html::textInput('search', Yii::$app->request->getQueryParam('search'),
                    ['class'=>'form-control', 'placeholder'=>Yii::t('common', 'Search')])?>
                <span class="input-group-btn">
                    <button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                  </span>
            </div>
        <?=Html::endForm()?>


        <?php
        $items = [
            [
                'label'=>Yii::t('common', 'Dashboard'),
                'url'=>['/'],
                'icon'=>'dashboard',
            ]
        ];

        if(Yii::$app->user->can('indexOrder')){
            $newOrdersCount = Order::find()->newStatus()->count();
            $newOrdersText=null;
            $newOrdersText = Yii::t('order', '{n, plural, =0{no new orders} =1{# new order} other{# new orders}}', ['n'=>$newOrdersCount]);
            $items[] = [
                'label' => Yii::t('order', 'Orders'),
                'encode'=>false,
                'template'=>'<a href="{url}">
                                                    {icon} {label} 
                                                    <span class="pull-right-container">
                                                        <small class="label pull-right bg-green">'.$newOrdersText.'</small>
                                                    </span>
                                               </a>',
                'url' => ['/order/order/index'],
                'icon'=>'inbox',
            ];
        }

        if(Yii::$app->user->can('indexProduct'))
            $items[] = ['label' => Yii::t('product', 'Products'), 'url' => ['/product/product/index'], 'icon'=>/*'th-list'*/ 'barcode'];
        if(Yii::$app->user->can('indexCategory'))
            $items[] = ['label' => Yii::t('category', 'Categories'), 'url' => ['/category/category/index'], 'icon'=>'list',];
        if(Yii::$app->user->can(User::ROLE_MANAGER))
            $items[] = ['label' => Yii::t('eav', 'Dynamic fields'), 'url' => ['/eav/dynamic-field/index'], 'icon'=>'outdent',];


        if(Yii::$app->user->can('indexUser'))
            $items[] = [
                'label' => Yii::t('user', 'Users'), 'url' => ['/user/manage/index/index'],'icon'=>'users'
            ];

        if(Yii::$app->user->can(User::ROLE_MANAGER)){
            $items[] =  [
                'label' => 'RBAC',
                'icon'=>'user-plus',
                'url'=>'javascript:void(0)',
                'options'=>['class'=>'gray'],
                'items'=>[
                    ['label'=>Yii::t('user', 'Roles'), 'icon'=>'user', 'url'=>['/rbac/role/index'], 'options'=>['class'=>Yii::$app->controller->route=='rbac/role/index' ? 'active':null]],
                    ['label'=>Yii::t('user', 'Permissions'), 'icon'=>'user', 'url'=>['/rbac/permission/index'], 'options'=>['class'=>Yii::$app->controller->route=='rbac/permission/index' ? 'active':null]],
                    ['label'=>Yii::t('user', 'Rules'), 'icon'=>'user', 'url'=>['/rbac/rule/index'], 'options'=>['class'=>Yii::$app->controller->route=='rbac/rule/index' ? 'active':null]],
                    ['label'=>Yii::t('user', 'Assignments'), 'icon'=>'user', 'url'=>['/rbac/assignment/index'], 'options'=>['class'=>Yii::$app->controller->route=='rbac/assignment/index' ? 'active':null]],
                ],
            ];
            $items[] =
                [
                'label' => Yii::t('user', 'Mailing of letters'),
                    'icon'=>'envelope',
                'url'=>['/user/delivery/delivery/index'],
                'options'=>['class'=>Yii::$app->controller->route=='user/delivery/delivery/index' ? 'active':null],
                'items'=>[
                    [
                        'label'=>Yii::t('user', 'Mailing of letters'),
                        'icon'=>'mail-forward',
                        'options'=>['class'=>Yii::$app->controller->route=='user/delivery/delivery/index' ? 'active':null],
                        'url'=>['/user/delivery/delivery/index']],
                    [
                        'label'=>Yii::t('user', 'Email messages in cron task'),
                        'icon'=>'mail-forward',
                        'options'=>['class'=>Yii::$app->controller->route=='user/delivery/cron-email-message/index' ? 'active':null],
                        'url'=>['/user/delivery/cron-email-message/index']],
                ],
            ];
        }



        if(Yii::$app->user->can('indexComment'))
            $items[] = [
                'label' => Yii::t('comment', 'Comments'),  'url'=>['/comment/comment/index'],'icon'=>'commenting'
            ];
        if(Yii::$app->user->can(User::ROLE_MANAGER))
            $items[] = [
                'label' => Yii::t('file', 'Files'),  'url'=>['/file/file-manage/index'], 'icon'=>'file-photo-o'
            ];
        if(Yii::$app->user->can('indexPage'))
            $items[] = ['label' => Yii::t('page', 'Pages'), 'url' => ['/page/page/index'], 'icon'=>'file',];
        if(Yii::$app->user->can('indexArticle'))
            $items[] = ['label' => Yii::t('article', 'Articles'), 'url' => ['/article/article/index'], 'icon'=>'file-text',];
        if(Yii::$app->user->can('indexTag'))
            $items[] = ['label' => Yii::t('tag', 'Tags'), 'url' => ['/tag/tag/index'], 'icon'=>'tags',];
        if(Yii::$app->user->can(User::ROLE_MANAGER)){
            $items[] =                 [
                'label' => 'I18N',
                'icon'=>'language',
                'url'=>'javascript:void(0)',
                'options'=>['class'=>'gray'],
                'items'=>[
                    ['label'=>'Source', 'icon'=>'language','options'=>['class'=>Yii::$app->controller->route=='i18n/source/index' ? 'active':null], 'url'=>['/i18n/source/index']],
                    ['label'=>'Messages', 'icon'=>'language','options'=>['class'=>Yii::$app->controller->route=='i18n/message/index' ? 'active':null],  'url'=>['/i18n/message/index']]
                ],
            ];
            $items[] =
                [
                    'label' => Yii::t('common', 'Console'),
                    'icon'=>'quote-right',
                    'url'=>['/console'],
            ];
        }


        ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items'=>$items
            ]
        ) ?>

    </section>

</aside>
