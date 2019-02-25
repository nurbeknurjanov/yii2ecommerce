<?php
/**
 * Configuration file for the "yii asset" console command.
 */

// In the console environment, some path aliases may not exist. Please define these:
Yii::setAlias('@webroot', '@frontend/web');
Yii::setAlias('@web', '/');
$rand = rand(1000,9999);
$dir = Yii::getAlias('@app').'/..';//console dir
return [
    // Adjust command/callback for JavaScript files compressing:
    //'jsCompressor' => 'java -jar compiler.jar --js {from} --js_output_file {to}',
    'jsCompressor' => "php $dir/yii minify --js_file {from} --js_output_file {to}",
    // Adjust command/callback for CSS files compressing:
    //'cssCompressor' => 'java -jar yuicompressor.jar --type css {from} -o {to}',
    //'cssCompressor' => 'grunt',
    'cssCompressor' => "php $dir/yii minify --css_file {from} --css_output_file {to}",
    // Whether to delete asset source after compression:
    'deleteSource' => false,
    // The list of asset bundles to compress:
    'bundles' => [
        \yii\web\JqueryAsset::class,
        \yii\widgets\PjaxAsset::class,
        \yii\jui\JuiAsset::class,
        \yii\bootstrap\BootstrapAsset::class,
        \yii\bootstrap\BootstrapPluginAsset::class,
        \yii\web\YiiAsset::class,
        \yii\widgets\ActiveFormAsset::class,
        \yii\validators\ValidationAsset::class,
        \kartik\base\WidgetAsset::class,
        \kartik\rating\StarRatingAsset::class,
        yii\grid\GridViewAsset::class,


        //all pages
        \order\assets\OrderAsset::class,
        \page\assets\PageAsset::class,


        //category
        \eav\assets\EavAsset::class,
        \category\assets\CategoryAsset::class,

        //site/index page
        \article\assets\ArticleAsset::class,

        //product detail
        \kartik\file\FileInputAsset::class,
        \kartik\file\SortableAsset::class,
        \kartik\file\DomPurifyAsset::class,
        \like\assets\LikeAsset::class,
        \favorite\assets\FavoriteAsset::class,
        \product\assets\ProductAsset::class,
        \file\assets\FileAsset::class,
        \file\widgets\file_video_network\assets\FileVideoNetworkAsset::class,
        \common\assets\LightboxAsset::class,



        //all pages
        \common\assets\CommonAsset::class,
        \frontend\assets\FrontendAppAsset::class,
        \common\assets\MenuAsset::class,
        \common\assets\NotifyAsset::class,
        \common\assets\PerfectScrollbarAsset::class,
        \common\assets\BootboxAsset::class,
        \themes\sakura\assets\SakuraThemeAsset::class,

    ],
    // Asset bundle for compression output:
    'targets' => [
        'all' => [
            'class' => \yii\web\AssetBundle::class,
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'js' => "all.sakura.min.$rand.js",
            'css' => "all.sakura.min.$rand.css",
        ],
    ],
    // Asset manager configuration:
    'assetManager' => [
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets',
    ],
];