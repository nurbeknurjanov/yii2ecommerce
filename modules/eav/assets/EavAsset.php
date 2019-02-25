<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */


namespace eav\assets;

use yii\helpers\Url;
use yii\web\AssetBundle;
use Yii;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class EavAsset extends AssetBundle
{
    public $sourcePath = '@eav/asset_source';

    public $css = [
        'css/eav.css',
    ];
    public $js = [
        'js/eav_fields.js',
        'js/eav_search_form.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
