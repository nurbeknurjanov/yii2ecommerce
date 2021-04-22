<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace common\assets;

use page\assets\PageAsset;
use Yii;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class MenuAsset extends AssetBundle
{

    public $sourcePath = '@common/bower/menu';
    public $js = [
        'hc-offcanvas-nav.js',
        'menu.js',
    ];
    public $css = [
        //'https://fonts.googleapis.com/icon?family=Material+Icons',
        //'https://fonts.googleapis.com/css?family=Raleway:200,300,400,600,700',
        'hc-offcanvas-nav.css',
    ];

    public $depends = [
        JqueryAsset::class,
    ];

    public static function register($view)
    {
        return parent::register($view);
    }
}