<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\assets;

use kartik\file\FileInputAsset;
use kartik\file\FileInputThemeAsset;
use yii\helpers\Url;
use yii\web\AssetBundle;
use Yii;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FileAsset extends AssetBundle
{
    public $sourcePath = '@file/asset_source';

    public $css = [
        'css/file.css',
    ];
    public $depends = [
        FileInputAsset::class,
        FileInputThemeAsset::class,
    ];
}
