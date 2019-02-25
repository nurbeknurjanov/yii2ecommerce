<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace themes\landing\assets;

use kartik\form\ActiveFormAsset;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\validators\ValidationAsset;
use yii\web\AssetBundle;
use Yii;
use yii\web\JqueryAsset;
use yii\web\View;
use yii\web\YiiAsset;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LandingThemeAsset extends AssetBundle
{
    public $sourcePath = '@themes/landing/asset_source';
    public $css = [
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/simple-line-icons.css',
        'css/slicknav.css',
        'css/owl.carousel.css',
        'css/owl.theme.css',
        'css/animate.css',
        'css/main.css',
        'css/responsive.css',
    ];
    public $js = [
        //'js/jquery-min.js',
        'js/tether.min.js',
        //'js/bootstrap.min.js',
        'js/mixitup.min.js',
        'js/owl.carousel.min.js',
        'js/jquery.slicknav.js',
        'js/jquery.nav.js',
        'js/smooth-scroll.js',
        'js/smooth-on-scroll.js',
        'js/wow.js',
        'js/jquery.counterup.min.js',
        'js/waypoints.min.js',
        'js/main.js',
    ];
    public $depends = [
        JqueryAsset::class,
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
        YiiAsset::class,
        ActiveFormAsset::class,
        ValidationAsset::class,
    ];

}
