<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace themes\sakura\assets;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\AssetBundle;
use Yii;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SakuraThemeAsset extends AssetBundle
{
    public $sourcePath = '@themes/sakura/asset_source';
    public $css = [
        //'css/bootstrap.css',
        'css/sakura.css',
        'css/dark.css',
        'css/adaptive.css',
    ];
    public $js = [
        'js/sakura.js',
        //'js/carousel.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\jui\JuiAsset',
    ];

    public static function register($view)
    {
        $view->registerCss("
            button{
            background:white;
            }
        ");
        return parent::register($view);
    }
}
