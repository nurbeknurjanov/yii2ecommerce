<?php

namespace frontend\assets;

use nirvana\infinitescroll\InfiniteScrollAsset;
use order\assets\OrderAsset;
use order\models\Order;
use richardfan\widget\JSRegister;
use yii\bootstrap\BootstrapAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\validators\ValidationAsset;
use yii\web\AssetBundle;
use Yii;
use yii\web\View;
use yii\web\YiiAsset;
use yii\widgets\ActiveFormAsset;
use category\models\Category;

/**
 * Main frontend application asset bundle.
 */
class FrontendAppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/frontend.css',
    ];
    public $js = [
    ];
    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        ActiveFormAsset::class,
        ValidationAsset::class
    ];

    public static function register($view)
    {
        if(Yii::$app->id=='app-frontend-app')
        {
            $infiniteScrollImgUrl = $view->assetManager->publish('@vendor/nirvana-msu/yii2-infinite-scroll/assets/images/ajax-loader.gif')[1];
            $imageCard=$view->assetManager->publish((new OrderAsset)->sourcePath."/images/".Order::ONLINE_PAYMENT_TYPE_CARD.".png")[1];
            $imagePaypal=$view->assetManager->publish((new OrderAsset)->sourcePath."/images/".Order::ONLINE_PAYMENT_TYPE_PAYPAL.".png")[1];

            JSRegister::begin(['position'=>$view::POS_HEAD]);
            ?>
            <script>
                var paymentTypeImages = '<?php // echo $orderBundle->baseUrl?>';
                var infiniteScrollImageUrl = '<?=$infiniteScrollImgUrl?>';
                var cardImageUrl = '<?=$imageCard?>';
                var paypalImageUrl = '<?=$imagePaypal?>';
                var appName = '<?=Yii::$app->name?>';

                var PAYMENT_TYPE_CASH = '<?=Order::PAYMENT_TYPE_CASH?>';
                var PAYMENT_TYPE_ONLINE = '<?=Order::PAYMENT_TYPE_ONLINE?>';
                var ONLINE_PAYMENT_TYPE_PAYPAL = '<?=Order::ONLINE_PAYMENT_TYPE_PAYPAL?>';
                var ONLINE_PAYMENT_TYPE_CARD = '<?=Order::ONLINE_PAYMENT_TYPE_CARD?>';

                var language = '<?=Yii::$app->language!=Yii::$app->sourceLanguage ? Yii::$app->language:''?>';// ru or ''

                var apiUrl = '<?php $url = Yii::$app->urlManagerApi->createAbsoluteUrl('/'); echo rtrim($url, '/'); ?>'; // http://api.sakura.com
                var apiUrlWithLanguage = apiUrl + (language?'/'+language:null); // http://api.sakura.com/ru

                //baseUrl ''
                //baseUrlWithLanguage '' or '/ru'

                var category_urls = [<?php
                    $categories = Category::getDb()->cache(function ($db) {
                        return Category::find()->enabled()->all();
                    }/*,$duration, $dependency*/);
                    $categories = ArrayHelper::map($categories, 'id', 'title_url');
                    echo '"'.implode('","', $categories).'"' ;
                    ?>];

                var ratingOptions = {
                    "showClear": true,
                    "size": "xs",
                    "step": 1,
                    "showCaption": false,
                    "displayOnly": true,
                    "language": language
                };

                var t=[];
                t['slogan'] = '<?=Yii::t('common', Yii::$app->params['slogan'])?>';
                t['All products'] = '<?=Yii::t('product', 'All products')?>';
                t['Home'] = '<?=Yii::t('common', 'Home')?>'
                t['Sort by'] = '<?=Yii::t('product', 'Sort by')?>'
                t['price'] = '<?=Yii::t('product-sort', 'price')?>'
                t['novelties'] = '<?=Yii::t('product-sort', 'novelties')?>'
                t['popular'] = '<?=Yii::t('product-sort', 'popular')?>'
                t['rating'] = '<?=Yii::t('product-sort', 'rating')?>'
                t['Load more'] = '<?=Yii::t('common', 'Load more')?>'
                t['pc'] = '<?=Yii::t('order', 'pc')?>'
                t['You added the item into shopping cart.'] = '<?=Yii::t('order', 'You added the item into shopping cart.')?>'
                t['Do you want to remove the item from compare ?'] = '<?=Yii::t('product', 'Do you want to remove the item from compare ?')?>'
                t['Remove'] = '<?=Yii::t('common', 'Remove')?>'
                t['You successfully added the item into favorites.'] = '<?=Yii::t('favorite', 'You successfully added the item into favorites.')?>'
                t['You successfully removed the item from favorites.'] = '<?=Yii::t('favorite', 'You successfully removed the item from favorites.')?>'
                t['You successfully added the item into compare.'] = '<?=Yii::t('product', 'You successfully added the item into compare.')?>'
                t['You successfully removed the item from compare.'] = '<?=Yii::t('product', 'You successfully removed the item from compare.')?>'
                t['You didn\'t select the items to compare.'] = "<?=Yii::t('product', 'You didn\'t select the items to compare.')?>"
                t['Buy'] = '<?=Yii::t('product', 'Buy')?>'
                t['In Shopping cart'] = '<?=Yii::t('order', 'In Shopping cart');?>'
                t['Issue the order'] = '<?=Yii::t('order', 'Issue the order');?>'
                t['Continue shopping'] = '<?=Yii::t('order', 'Continue shopping');?>'
                t['Price'] = '<?=Yii::t('product', 'Price');?>'
                t['Amount'] = '<?=Yii::t('order', 'Amount');?>'
                t['Count'] = '<?=Yii::t('order', 'Count');?>'
                t['Product'] = '<?=Yii::t('product', 'Product');?>'
                t['Shopping cart'] = '<?=Yii::t('order', 'Shopping cart');?>'
                t['Are you sure you want to remove this item from shopping cart ?'] = '<?=Yii::t('order', 'Are you sure you want to remove this item from shopping cart ?');?>'
                t['Issue the order'] = '<?=Yii::t('order', 'Issue the order');?>'
                t['You removed the item from shopping cart.'] = '<?=Yii::t('order', 'You removed the item from shopping cart.');?>'
                t['Your shopping cart is empty.'] = '<?=Yii::t('order', 'Your shopping cart is empty.');?>'
                t['{attribute} cannot be blank.'] = '<?=Yii::t('yii', '{attribute} cannot be blank.');?>'
                t['{attribute} must be a number.'] = '<?=Yii::t('yii', '{attribute} must be a number.');?>'
                t['{attribute} must be no less than {min}.'] = '<?=Yii::t('yii', '{attribute} must be no less than {min}.');?>'
                t['Go to the shopping cart'] = '<?=Yii::t('order', 'Go to the shopping cart');?>'
                t['Information about buyer'] = '<?=Yii::t('order', 'Information about buyer');?>'
                t['Name'] = '<?=Yii::t('common', 'Name');?>'
                t['Email'] = '<?=Yii::t('common', 'Email');?>'
                t['Phone'] = '<?=Yii::t('common', 'Phone');?>'
                t['City'] = '<?=Yii::t('order', 'City');?>'
                t['Address'] = '<?=Yii::t('order', 'Address');?>'
                t['DescriptionOrder'] = '<?=Yii::t('order', 'Description');?>'
                t['Total to pay'] = '<?=Yii::t('order', 'Total to pay');?>'
                t['Back to shopping cart'] = '<?=Yii::t('order', 'Back to shopping cart');?>'
                t['Make an order'] = '<?=Yii::t('order', 'Make an order');?>'
                t['In order'] = '<?=Yii::t('order', 'In order');?>'
                t['Select'] = '<?=Yii::t('common', 'Select');?>'
                t['Delivery'] = '<?=Yii::t('order', 'Delivery');?>'
                t['Payment type'] = '<?=Yii::t('order', 'Payment type');?>'
                t['Cash'] = '<?=Yii::t('order', 'Cash');?>'
                t['Online'] = '<?=Yii::t('order', 'Online');?>'
                t['Pickup'] = '<?=Yii::t('order', 'Pickup');?>'
                t['{name} Delivery service'] = '<?=Yii::t('order', '{name} Delivery service');?>'
                t['Expire date'] = '<?=Yii::t('order', 'Expire date');?>'
                t['Card number'] = '<?=Yii::t('order', 'Card number');?>'
            </script>
            <?php
            JSRegister::end();
        }

        return parent::register($view);
    }
}
