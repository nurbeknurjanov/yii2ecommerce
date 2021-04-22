<?php

/* @var $this \extended\view\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use order\models\Basket;
use favorite\models\FavoriteLocal;
use category\models\Category;
use product\models\Compare;
use product\models\search\ProductSearchFrontend;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use \extended\helpers\Helper;
use common\assets\CommonAsset;
use frontend\assets\FrontendAppAsset;
use yii\web\JsExpression;
use themes\sakura\assets\SakuraThemeAsset;
use common\assets\BootboxAsset;
use \common\assets\NotifyAsset;
use \common\assets\PerfectScrollbarAsset;
use common\assets\LightboxAsset;
use yii\grid\GridViewAsset;
use common\assets\BootstrapSelectAsset;
use extended\helpers\MenuTree;
use extended\helpers\Tree;
use common\assets\MenuAsset;

FrontendAppAsset::register($this);
CommonAsset::register($this);
BootboxAsset::register($this);
NotifyAsset::register($this);
PerfectScrollbarAsset::register($this);
LightboxAsset::register($this);
GridViewAsset::register($this);
BootstrapSelectAsset::register($this);
MenuAsset::register($this);

$request = Yii::$app->request;

if(isset($this->assetManager->bundles['all']))
    $this->clearAssetBundle(SakuraThemeAsset::class);
$themeBundle = SakuraThemeAsset::register($this);
//$this->theme->baseUrl = $themeBundle->baseUrl;

if(!isset($this->params['title'])){
    if($this->title)
        $this->params['title'] = $this->title.' | '.Yii::$app->name;
    else
        $this->params['title'] = Yii::$app->name.' - '.Yii::t('common', Yii::$app->params['slogan']);
}
if(!isset($this->params['keywords']))
    $this->params['keywords'] = Yii::$app->params['keywords'];
if(empty($this->params['description']))
    $this->params['description'] = Yii::t('common', Yii::$app->params['description']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <link rel="shortcut icon" href="<?=$themeBundle->baseUrl;?>/images/favicon.ico" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <meta name="robots" content="index, follow" />
    <meta name="author" content="Nurbek Nurjanov">
    <meta name="keywords" content="<?=$this->params['keywords']?>">
    <meta name="description" content="<?=$this->params['description']?>">
    <title><?= $this->params['title'] ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">


    <div class="header">
        <div id="header">
            <?=$this->render('header') ?>
        </div>
    </div>

    <div class="container">
        <div id="app">
            <?php
            echo $this->yieldContent($content);
            ?>
        </div>
    </div>
</div>

<footer class="footer gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-xs-4">
                <div class="footer-block">
                    <label><?=Yii::t('common', 'Contacts');?></label> <br/>
                    <i class="glyphicon glyphicon-envelope"></i> <?=Yii::$app->params['supportEmail']?> <br>
                    <i class="glyphicon glyphicon-phone-alt" style="top:0"></i> <span><?=Yii::$app->params['supportPhone']?></span>
                </div>
            </div>
            <div class="col-lg-4 col-xs-4">
                <div class="footer-block">
                    <label><?=Yii::t('common', 'About company');?></label>
                </div>
                <?=Nav::widget([
                    'id'=>'footerNav1',
                    'encodeLabels'=>false,
                    'options' => ['class' => 'footerNav'],
                    'items' => [
                        ['label' => Yii::t('common', 'About us'),
                            'url' => ['/page/page/view', 'page_title_url'=>'about_us'],
                            'active'=>$request->get('page_title_url')=='about_us'],
                        ['label' => Yii::t('common', 'Feedback'), 'url' => ['/site/contact']],
                    ],
                ]);?>
            </div>
            <div class="col-lg-4 col-xs-4">
                <div class="footer-block">
                    <label><?=Yii::t('common', 'About shop');?></label>
                </div>
                <?=Nav::widget([
                    'id'=>'footerNav2',
                    'encodeLabels'=>false,
                    'options' => ['class' => 'footerNav'],
                    'items' => [
                        ['label' => Yii::t('common', 'Delivery & payment'),
                            'url' =>['/page/page/view', 'page_title_url'=>'delivery']],
                        ['label' => Yii::t('common', 'Guarantee'),
                            'url' =>['/page/page/view', 'page_title_url'=>'guarantee']],
                    ],
                ]);?>
            </div>
        </div>
        <div class="copyright gray"><?=Yii::$app->name?><br> <?=Yii::t('common', 'All rights reserved');?> &copy; 2018</div>
    </div>
</footer>

<?php $this->endBody() ?>
<?php
if (YII_ENV_PROD){
    ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-117109569-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-117109569-1');
    </script>
    <?php
}
?>
</html>
<?php $this->endPage() ?>
