<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */


namespace order\assets;

use country\assets\CountryAsset;
use extended\vendor\BootstrapSelectAsset;
use order\models\Order;
use yii\helpers\Url;
use yii\web\AssetBundle;
use Yii;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class OrderAsset extends AssetBundle
{
    public $sourcePath = '@order/asset_source';

    public $js = [
        'js/basket.js',
        'js/order.js',
        'js/order_form.js',
    ];
    public $css = [
        'css/basket.css',
        'css/order.css',
        'css/order_form.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        CountryAsset::class,
        BootstrapSelectAsset::class
    ];

    /**
     * Registers this asset bundle with a view.
     * @param View $view the view to be registered with
     * @return static the registered asset bundle instance
     */
    public static function register($view)
    {

        $view->registerJs("
            var PAYMENT_TYPE_CASH='".Order::PAYMENT_TYPE_CASH."';
            var PAYMENT_TYPE_ONLINE='".Order::PAYMENT_TYPE_ONLINE."';
            
            var ONLINE_PAYMENT_TYPE_PAYPAL='".Order::ONLINE_PAYMENT_TYPE_PAYPAL."';
            var ONLINE_PAYMENT_TYPE_CARD='".Order::ONLINE_PAYMENT_TYPE_CARD."';
        ", $view::POS_HEAD);

        return parent::register($view);
    }
}
