<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * Date: 12/17/19
 * Time: 6:22 PM
 */

namespace common\assets;

use Yii;
use yii\web\AssetBundle;
use yii\web\View;

class GeoCompleteAsset extends AssetBundle
{
    public $sourcePath = '@common/bower/geo-complete';
    public $js = [
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyA5EJvby7XQns79IiN7ZHcGszDxpkETEiM&libraries=places&language=en',
        'js/geocomplete.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}