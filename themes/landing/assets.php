<?php
/**
 * Configuration file for the "yii asset" console command.
 */

use yii\bootstrap\BootstrapAsset;

// In the console environment, some path aliases may not exist. Please define these:
Yii::setAlias('@webroot', '@landing/web');
Yii::setAlias('@web', '/');

Yii::$container->set(BootstrapAsset::class, [
    'css' => [],
]);

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
        \themes\landing\assets\LandingThemeAsset::class,
    ],
    // Asset bundle for compression output:
    'targets' => [
        'all' => [
            'class' => \yii\web\AssetBundle::class,
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'js' => "all.landing.min.$rand.js",
            'css' => "all.landing.min.$rand.css",
        ],
    ],
    // Asset manager configuration:
    'assetManager' => [
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets',
    ],
];