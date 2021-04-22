<?php

namespace common\assets;

use yii\web\AssetBundle;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MapAsset extends AssetBundle
{
    public $sourcePath = '@common/bower/gmappicker';
    public $css = [
        'jquery-gmaps-latlon-picker.css',
    ];
    public $js = [
        'http://maps.googleapis.com/maps/api/js?sensor=false',
        'jquery-gmaps-latlon-picker.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
