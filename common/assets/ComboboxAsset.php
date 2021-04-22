<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace common\assets;

use yii\web\AssetBundle;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ComboboxAsset extends AssetBundle
{
    public $sourcePath = '@common/bower/combobox';
    public $css = [
        'css/combobox.css',
    ];
    public $js = [
        'js/combobox.js',
    ];
    public $depends = [
        'yii\jui\JuiAsset',
    ];
}
