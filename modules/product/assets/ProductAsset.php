<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */


namespace product\assets;

use category\assets\CategoryAsset;
use comment\assets\CommentAsset;
use common\assets\CommonAsset;
use eav\assets\EavAsset;
use favorite\assets\FavoriteAsset;
use yii\helpers\Url;
use yii\web\AssetBundle;
use Yii;
use yii\web\View;
use common\assets\ZoomAsset;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ProductAsset extends AssetBundle
{
    public $sourcePath = '@product/asset_source';
    public $js = [
        'js/compare.js',
        'js/text_search_form.js',
        'js/multiple_products.js',
        'js/product_view.js',
    ];
    public $css = [
        'css/products_list.css',
        'css/product_detail.css',
        'css/rating.css',
        'css/compare.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        FavoriteAsset::class,
        EavAsset::class,
        CategoryAsset::class,
        CommentAsset::class,
        CommonAsset::class,
        ZoomAsset::class
    ];

    public static function register($view)
    {
        $addCompare = Yii::t('product', 'Add to compare');
        $removeCompare = Yii::t('product', 'Remove from compare');
        $view->registerJs("
            var addCompareTitle = '{$addCompare}';
            var removeCompareTitle = '{$removeCompare}';
        ", $view::POS_HEAD, 'compare');
        FavoriteAsset::register($view);
        return parent::register($view);
    }
}
