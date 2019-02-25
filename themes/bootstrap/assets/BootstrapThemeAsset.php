<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace themes\bootstrap\assets;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\AssetBundle;
use Yii;
use yii\web\View;
use themes\sakura\assets\SakuraThemeAsset;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */

Yii::$container->set(SakuraThemeAsset::class, [
    'css'=>[
        'css/sakura.css',
        'css/adaptive.css'
    ],
]);

class BootstrapThemeAsset extends AssetBundle
{
    public $sourcePath = '@themes/bootstrap/asset_source';
    public $js = [
    ];
    public $depends = [
        SakuraThemeAsset::class
    ];
}
