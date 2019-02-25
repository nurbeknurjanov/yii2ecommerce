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
use themes\landing\assets\LandingThemeAsset;

/*FrontendAppAsset::register($this);
CommonAsset::register($this);
\common\assets\BootboxAsset::register($this);
\common\assets\NotifyAsset::register($this);
\common\assets\PerfectScrollbarAsset::register($this);
\common\assets\LightboxAsset::register($this);
\yii\grid\GridViewAsset::register($this);
\extended\vendor\BootstrapSelectAsset::register($this);*/

$homePage = Yii::$app->controller->route=='site/index';
if($homePage)
    $homePageLink='';
else
    $homePageLink = Url::to(['/']);

if(isset($this->assetManager->bundles['all']))
    $this->clearAssetBundle(LandingThemeAsset::class);
$themeBundle = LandingThemeAsset::register($this);
$this->theme->baseUrl = $themeBundle->baseUrl;

if(!isset($this->params['title'])){
    if($this->title)
        $this->params['title'] = $this->title;
    else
        $this->params['title'] = Yii::t('common', Yii::$app->name);
}
if(!isset($this->params['keywords']))
    $this->params['keywords'] = 'ecommerce, yii2, php, framework, cms, platform';
if(!isset($this->params['description']))
    $this->params['description'] = Yii::t('common', 'Ecommerce platform based on Yii2 PHP Framework');
$this->beginPage()
?><!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="shortcut icon" href="<?=$themeBundle->baseUrl;?>/img/favicon.png?1" >
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <?= Html::csrfMetaTags() ?>
    <meta name="robots" content="index, follow" />
    <meta name="google-site-verification" content="PPpGrWJe461ffL-CagzxRRcsE9K5RDTlIJCB_3jdY9g" />
    <meta name="author" content="Nurbek Nurjanov">
    <meta name="keywords" content="<?=$this->params['keywords']?>">
    <meta name="description" content="<?=$this->params['description']?>">
    <title><?= $this->params['title'] ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<!-- Header Section Start -->
<header id="hero-area">
    <div class="overlay"></div>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top scrolling-navba bg-faded
    <?=$homePage?'':'menu-bg-stable'?> " id="white-bg">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="<?=Yii::$app->homeUrl?>" >
                    SAKURA<span style="display: block; position: static; top: -20px; left: 0; margin-top: -13px; margin-left: 1px;">commerce</span>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto w-100 justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$homePageLink?>#hero-area"><?=Yii::t('landing', 'Home')?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$homePageLink?>#main_advantage"><?=Yii::t('landing', 'Main advantage')?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$homePageLink?>#other_advantages"><?=Yii::t('landing', 'Other advantages')?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$homePageLink?>#themes"><?=Yii::t('landing', 'Themes')?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$homePageLink?>#pricing"><?=Yii::t('landing', 'Pricing')?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$homePageLink?>#contact"><?=Yii::t('landing', 'Contact')?></a>
                    </li>
                    <li class="nav-item">
                        <?php
                        if(Yii::$app->language==Yii::$app->sourceLanguage){
                            ?>
                            <a class="nav-link" href="<?=Url::to(["/".Yii::$app->controller->route]+$_GET+['language'=>'ru'])?>">RU</a>
                            <?php
                        }else{
                            ?>
                            <a class="nav-link" href="<?=Url::to(["/".Yii::$app->controller->route]+$_GET+['language'=>'en-US'])?>">EN</a>
                            <?php
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Start -->
    <ul class="mobile-menu">
        <li>
            <a href="#hero-area"><?=Yii::t('landing', 'Home')?></a>
        </li>
        <li>
            <a href="<?=$homePageLink?>#main_advantage"><?=Yii::t('landing', 'Main advantage')?></a>
        </li>
        <li>
            <a href="<?=$homePageLink?>#other_advantages"><?=Yii::t('landing', 'Other advantages')?></a>
        </li>
        <li>
            <a href="<?=$homePageLink?>#themes"><?=Yii::t('landing', 'Themes')?></a>
        </li>
        <li>
            <a href="<?=$homePageLink?>#pricing"><?=Yii::t('landing', 'Pricing')?></a>
        </li>
        <li>
            <a href="<?=$homePageLink?>#contact"><?=Yii::t('landing', 'Contact')?></a>
        </li>
    </ul>
    <!-- Mobile Menu End -->

    <?php
    if($homePage){
        ?>
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-10">
                    <div class="carousel-slider owl-carousel owl-theme">
                        <div class="item active">
                            <div class="contents text-center">
                                <h1 class="wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                                    <?=Yii::t('landing', 'Caption')?>
                                </h1>
                                <p class="lead  wow fadeIn" data-wow-duration="1000ms" data-wow-delay="400ms">
                                    <?=Yii::t('landing', 'Caption Description')?>
                                </p>
                                <a href="<?=Yii::$app->urlManagerFrontend->createAbsoluteUrl('/', 'https')?>" target="_blank" class="btn btn-common wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                                    <?=Yii::t('landing', 'Demo')?>
                                </a>
                                <a href="<?=Yii::$app->urlManagerBackend->createAbsoluteUrl('/', 'https')?>" target="_blank" class="btn btn-border wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                                    <?=Yii::t('landing', 'Demo Backend')?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>


</header>
<!-- Header Section End -->

<?=$content?>

<!-- Contact Icon Start -->
<div class="section contact-icon">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="box-icon wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="500ms">
                    <div class="icon icon-secondary">
                        <i class="icon-envelope"></i>
                    </div>
                    <p>
                        nurbek.nurjanov@mail.ru
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="box-icon wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="700ms">
                    <div class="icon icon-tertiary">
                        <i class="icon-phone"></i>
                    </div>
                    <p>
                        (+996)558-01-14-77
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact Icon End -->

<!-- Footer Section Start -->
<footer>


    <!-- Copyright Start  -->
    <div id="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="site-info pull-left wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <p>Copyright © 2018 <?=Yii::t('landing', 'All rights reserved.')?></p>
                    </div>
                    <div class="bottom-social-icons social-icon pull-right  wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <!--<a class="twitter" href="https://twitter.com/GrayGrids"><i class="fa fa-twitter"></i></a>
                        <a class="facebook"" href="https://web.facebook.com/GrayGrids"><i class="fa fa-facebook"></i></a>
                        <a class="google-plus"" href="https://plus.google.com/+GrayGrids"><i class="fa fa-google-plus"></i></a>
                        <a class="linkedin" href="https://www.linkedin.com/GrayGrids"><i class="fa fa-linkedin"></i></a>
                        <a class="dribble" href="https://dribbble.com/GrayGrids"><i class="fa fa-dribbble"></i></a>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->

</footer>
<!-- Footer Section End -->

<!-- Go To Top Link -->
<a href="#" class="back-to-top">
    <i class="fa fa-arrow-up"></i>
</a>



<?php $this->endBody() ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-117109569-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-117109569-1');
</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter48411722 = new Ya.Metrika2({
                    id:48411722,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/48411722" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</body>
</html>
<?php $this->endPage() ?>