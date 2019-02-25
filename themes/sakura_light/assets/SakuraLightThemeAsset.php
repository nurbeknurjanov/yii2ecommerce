<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace themes\sakura_light\assets;

use themes\sakura\assets\SakuraThemeAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\AssetBundle;
use Yii;
use yii\web\View;

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

class SakuraLightThemeAsset extends \themes\sakura\assets\SakuraThemeAsset
{
    public $sourcePath = '@themes/sakura_light/asset_source';
    public $css = [
        'css/light.css',
    ];
    public $js = [
    ];

    public $depends = [
        SakuraThemeAsset::class
    ];
}
