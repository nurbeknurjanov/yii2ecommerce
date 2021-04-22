<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace themes\adminlte3\assets;

use common\assets\CommonAsset;
use hail812\adminlte3\assets\FontAwesomeAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\AssetBundle;
use Yii;
use yii\web\View;
use user\models\User;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminLTEAsset extends AssetBundle
{
    public $sourcePath = '@themes/adminlte3/asset_source';
    public $css = [
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700'
    ];
    public $js = [
        'js/adminlte.js',
        'js/Chart.js',
    ];
    public $depends = [
        CommonAsset::class,
        FontAwesomeAsset::class,
        \hail812\adminlte3\assets\AdminLteAsset::class
    ];
}
