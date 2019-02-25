<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\BackendAppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\assets\BootboxAsset;
use user\models\User;
use common\assets\CommonAsset;

BackendAppAsset::register($this);
CommonAsset::register($this);
BootboxAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->formatter->asTextLimit(Yii::$app->name, 20),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);


    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/user/guest/login']];
    } else {
        if(Yii::$app->user->can('indexOrder'))
            $menuItems[] = ['label' => 'Orders', 'url' => ['/order/order/index']];
        if(Yii::$app->user->can('indexProduct'))
            $menuItems[] = ['label' => 'Products', 'url' => ['/product/product/index']];
        if(Yii::$app->user->can('indexCategory'))
            $menuItems[] = ['label' => 'Categories', 'url' => ['/category/category/index']];
        if(Yii::$app->user->can(User::ROLE_MANAGER))
            $menuItems[] = ['label' => 'Dynamic fields', 'url' => ['/eav/dynamic-field/index']];

        $menuItems['modules'] = ['label'=>'Modules'];
        if(Yii::$app->user->can('indexUser'))
            $menuItems['modules']['items']['user'] = [
                'label' => 'Users', 'url' => ['/user/manage/index/index'],
            ];

        if(Yii::$app->user->can(User::ROLE_MANAGER)){
            $menuItems['modules']['items']['user']['items'][] =  [
                'label' => 'RBAC',
                'url'=>'javascript:void(0)',
                'options'=>['class'=>'gray'],
                'items'=>[
                    ['label'=>'Roles', 'url'=>['/rbac/role/index'], 'options'=>['class'=>Yii::$app->controller->route=='rbac/role/index' ? 'active':null]],
                    ['label'=>'Permissions', 'url'=>['/rbac/permission/index'], 'options'=>['class'=>Yii::$app->controller->route=='rbac/permission/index' ? 'active':null]],
                    ['label'=>'Rules', 'url'=>['/rbac/rule/index'], 'options'=>['class'=>Yii::$app->controller->route=='rbac/rule/index' ? 'active':null]],
                    ['label'=>'Assignments', 'url'=>['/rbac/assignment/index'], 'options'=>['class'=>Yii::$app->controller->route=='rbac/assignment/index' ? 'active':null]],
                ],
            ];
            $menuItems['modules']['items']['user']['items'][] =                          [
                'label' => 'Delivery',
                'url'=>['/user/delivery/delivery/index'],
                'options'=>['class'=>Yii::$app->controller->route=='user/delivery/delivery/index' ? 'active':null],
                'items'=>[
                    [
                        'label'=>'Cron email messages',
                        'options'=>['class'=>Yii::$app->controller->route=='user/delivery/cron-email-message/index' ? 'active':null],
                        'url'=>['/user/delivery/cron-email-message/index']],
                ],
            ];
        }



        if(Yii::$app->user->can('indexComment'))
            $menuItems['modules']['items'][] = [
                'label' => 'Comments',  'url'=>['/comment/comment/index'],
            ];
        if(Yii::$app->user->can(User::ROLE_MANAGER))
            $menuItems['modules']['items'][] = [
                'label' => 'Files',  'url'=>['/file/file-manage/index'],
            ];
        if(Yii::$app->user->can('indexPage'))
            $menuItems['modules']['items'][] = ['label' => 'Pages', 'url' => ['/page/page/index']];
        if(Yii::$app->user->can('indexArticle'))
            $menuItems['modules']['items'][] = ['label' => 'Articles', 'url' => ['/article/article/index']];
        if(Yii::$app->user->can('indexTag'))
            $menuItems['modules']['items'][] = ['label' => 'Tags', 'url' => ['/tag/tag/index']];
        if(Yii::$app->user->can(User::ROLE_MANAGER)){
            $menuItems['modules']['items'][] =                 [
                'label' => 'I18N',
                'url'=>'javascript:void(0)',
                'options'=>['class'=>'gray'],
                'items'=>[
                    ['label'=>'Source', 'options'=>['class'=>Yii::$app->controller->route=='i18n/source/index' ? 'active':null], 'url'=>['/i18n/source/index']],
                    ['label'=>'Messages', 'options'=>['class'=>Yii::$app->controller->route=='i18n/message/index' ? 'active':null],  'url'=>['/i18n/message/index']]
                ],
            ];
            $menuItems['modules']['items'][] =                 [
                'label' => 'Console',
                'url'=>['/console'],
            ];
        }


        $menuItems[] = [
            'label' => Yii::$app->user->identity->fullName,
            //'visible'=>true,
            'items'=>[
                ['label' => 'My profile', 'url' => ['/user/profile/profile']],
                ['label' => 'Edit profile', 'url' => ['/user/profile/edit-profile',]],
                ['label' => 'Change email', 'url' => ['/user/profile/change-email']],
                Yii::$app->user->identity->password_hash ? ['label' => 'Change password', 'url' => ['/user/profile/change-password']]:['label' => 'Set password', 'url' => ['/user/profile/set-password']],
                ['label' => 'Share link to register', 'url' => ['/user/profile/share',]],
                ['label' => 'Invite to register', 'url' => ['/user/profile/invite',]],
                ['label' =>
                    'Logout',
                    'url' => ['/user/profile/logout'],
                    'linkOptions' => ['data-method' => 'post']],
            ],
        ];
    }
    $languages = (new \i18n\models\I18nSourceMessage)->languageValues;
    $languageItems = $languages;
    array_walk($languageItems, function(&$value, $key) { $value = [
        'label'=> $value,
        'url'=>[Yii::$app->controller->route=='site/index' && $_GET===[] ? '/':null,  'language'=>$key]+$_GET,
        'active'=>Yii::$app->language==$key,
        'encode'=>false,
    ]; });
    $menuItemLanguage = ['label' => $languages[Yii::$app->language],'encode'=>false, 'items'=>$languageItems];
    $menuItems[] = $menuItemLanguage;


    echo Nav::widget([
        'activateParents'=>true,
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?php
        echo $this->yieldContent($content);
        //echo $content;
        ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?=Yii::$app->name?> <?= date('Y') ?></p>
    </div>
</footer>
<?php
if(isset($this->blocks['widgets']))
    echo $this->blocks['widgets'];
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
