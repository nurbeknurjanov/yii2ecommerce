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
use themes\vue\assets\VueThemeAsset;
use common\assets\BootboxAsset;
use \common\assets\NotifyAsset;
use \common\assets\PerfectScrollbarAsset;
use common\assets\LightboxAsset;
use yii\grid\GridViewAsset;
use extended\vendor\BootstrapSelectAsset;
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
    $this->clearAssetBundle(VueThemeAsset::class);
$themeBundle = VueThemeAsset::register($this);
//$this->theme->baseUrl = $themeBundle->baseUrl;

if(!isset($this->params['title'])){
    if($this->title)
        $this->params['title'] = $this->title;
    else
        $this->params['title'] = Yii::t('common', Yii::$app->name);
}
if(!isset($this->params['keywords']))
    $this->params['keywords'] = 'ecommerce, yii2, php, shop, store, cms, platform';
if(!isset($this->params['description']))
    $this->params['description'] = Yii::t('common', 'Ecommerce platform based on Yii2 PHP Framework');
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
        <?=$this->render('_menu_top')?>

        <div class="container">
            <div class="row header-content" >
                <div class="col-lg-2 col-sm-2 col-xs-2 left-block">
                    <a class="logo" href="<?=Url::to(['/'])?>">LOGO</a>
                    <a class="min-logo" href="<?=Url::to(['/']);?>">L</a>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-10 middle-block">
                    <div id="slogan"><?=Yii::t('common', 'Ecommerce platform based on Yii2 PHP Framework');?></div>
                    <?php
                    if(isset($this->params['searchModel']))
                        $searchModel = $this->params['searchModel'];
                    else{
                        $searchModel = new ProductSearchFrontend;
                        $searchModel->load(Yii::$app->request->queryParams);
                    }
                    ?>
                    <?php
                    $action = ['/product/product/list'];
                    /*if($searchModel->category){
                        $action['category_id'] = $searchModel->category->id;
                        $action['title_url'] = $searchModel->category->title_url;
                    }*/
                    $form = ActiveForm::begin([
                        'id'=>'textSearchForm',
                        'action' => $action,
                        'method' => 'get',
                        'options' => ['data' => ['pjax' => true]],//если будет внутри Pjax тогда имеет смысл

                    ]);
                    ?>
                    <div class="input-group search-block ">

                        <?php //echo Html::activeTextInput($searchModel, 'q', ['class'=>'form-control','placeholder'=>'Search for...']);?>

                        <?php echo AutoComplete::widget([
                            'model' => $searchModel,
                            'attribute' => 'q',
                            'options'=>['class'=>'form-control', 'placeholder'=>Yii::t('common', 'Type the search value...')],
                            'clientOptions' => [
                                'source' =>Url::to(['/product/product/select']),
                                'select' =>new JsExpression("function(event, ui) {
                                        //alert(ui.item.label + ui.item.value);
                                        $(this).val(ui.item.value);
                                        $(this).parents('form').submit();
                                    }"),
                            ],
                        ]);?>
                        <span class="input-group-btn">
                            <?=Html::submitButton('<i class="glyphicon glyphicon-search"></i>', ['class'=>'btn btn-default',]);?>
                        </span>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="col-lg-4 col-sm-4 col-xs-12 right-block">
                    <div class="phone">
                        <i class="glyphicon glyphicon-phone-alt"></i>
                        +996 (558) 01-14-77
                    </div>
                    <div class="basket-block">
                        <div><?=Yii::t('order', 'In Shopping cart');?></div>
                        <a href="<?=Url::to(['/order/order/create1']);?>" class="btn <?=Basket::getCount()>0 ? 'basketActive':'btn-default';?>">
                            <i class="glyphicon glyphicon-shopping-cart"></i>
                            <?=Html::tag('span', Basket::getNProductsForAmount() , ['id'=>'basketCountSpan',]);?>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <?=$this->render('_menu_categories')?>


    </div>


    <div class="container">
        <?php
        //echo $this->yieldContent($content);
        ?>
        <div id="app"></div>
    </div>
</div>

<footer class="footer gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-xs-4">
                <div class="footer-block">
                    <label><?=Yii::t('common', 'Contacts');?></label> <br/>
                    <i class="glyphicon glyphicon-envelope"></i> nurbek.nurjanov@mail.ru <br>
                    <i class="glyphicon glyphicon-phone-alt" style="top:0"></i> <span>+996 558 01-14-77</span>
                </div>
            </div>
            <div class="col-lg-4 col-xs-4">
                <div class="footer-block">
                    <label><?=Yii::t('common', 'About company');?></label>
                </div>
                <?=Nav::widget([
                    'encodeLabels'=>false,
                    'options' => ['class' => 'footerNav'],
                    'items' => [
                        ['label' => Yii::t('common', 'About us'), 'url' => ['/page/page/view', 'url'=>'about_us'], 'active'=>$request->get('url')=='about_us'],
                        ['label' => Yii::t('common', 'Feedback'), 'url' => ['/site/contact']],
                    ],
                ]);?>
            </div>
            <div class="col-lg-4 col-xs-4">
                <div class="footer-block">
                    <label><?=Yii::t('common', 'About shop');?></label>
                </div>
                <?=Nav::widget([
                    'encodeLabels'=>false,
                    'options' => ['class' => 'footerNav'],
                    'items' => [
                        ['label' => Yii::t('common', 'Delivery & payment'), 'url' =>['/page/page/view', 'url'=>'delivery'], 'active'=>$request->get('url')=='delivery'],
                        ['label' => Yii::t('common', 'Guarantee'), 'url' =>['/page/page/view', 'url'=>'guarantee'], 'active'=>$request->get('url')=='guarantee'],
                    ],
                ]);?>
            </div>
        </div>
        <div class="copyright gray"><?=Yii::$app->name?><br> <?=Yii::t('common', 'All rights reserved');?> &copy; 2018</div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
