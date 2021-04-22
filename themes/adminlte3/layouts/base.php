<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\ArrayHelper;
use user\models\User;
use yii\helpers\Url;
use \themes\adminlte3\assets\AdminLTEAsset;

/* @var $this \extended\view\View */
/* @var $content string */

\backend\assets\BackendAppAsset::register($this);
\common\assets\CommonAsset::register($this);
\common\assets\BootboxAsset::register($this);
\common\assets\NotifyAsset::register($this);
\common\assets\PerfectScrollbarAsset::register($this);
\yii\grid\GridViewAsset::register($this);
common\assets\BootstrapSelectAsset::register($this);

if(isset($this->assetManager->bundles['all']))
    $this->clearAssetBundle(AdminLTEAsset::class);
$themeBundle = AdminLTEAsset::register($this);
//$this->theme->baseUrl = $themeBundle->baseUrl;
//$themeBundle->skin = 'skin-blue';
if(!isset($this->params['title'])){
    if($this->title)
        $this->params['title'] = $this->title.' | '.Yii::$app->name;
    else
        $this->params['title'] = Yii::$app->name.' - '.Yii::t('common', 'ecommerce platform based on Yii2 PHP Framework');
}
if(!isset($this->params['keywords']))
    $this->params['keywords'] = 'ecommerce, yii2, php, framework, cms, platform';
if(!isset($this->params['description']))
    $this->params['description'] = Yii::t('common', 'Ecommerce platform based on Yii2 PHP Framework');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <link rel="shortcut icon" type="image/png" href="<?=$themeBundle->baseUrl?>/images/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <meta name="robots" content="index, follow" />
    <meta name="author" content="Nurbek Nurjanov">
    <meta name="keywords" content="<?=$this->params['keywords']?>">
    <meta name="description" content="<?=$this->params['description']?>">
    <title><?= $this->params['title'] ?></title>
    <?php $this->head() ?>
</head>
<?php
if(!isset($this->params['bodyClass']))
  $this->params['bodyClass'] = 'hold-transition sidebar-mini';
?>
<body class="<?=$this->params['bodyClass']?>">
    <?php $this->beginBody() ?>
        <?=$content?>
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
</body>
</html>
<?php $this->endPage() ?>
