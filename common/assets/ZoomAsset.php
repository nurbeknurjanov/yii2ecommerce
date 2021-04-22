<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace common\assets;



namespace common\assets;

use yii\web\AssetBundle;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ZoomAsset extends AssetBundle
{
    public $sourcePath = '@common/bower/zoom';
    public $css = [
    ];
    public $js = [
        'js/zoomsl-3.0.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
