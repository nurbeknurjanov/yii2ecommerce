<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace product;

use category\url_rules\CategoryUrlRule;
use eav\assets\EavAsset;
use product\url_rules\ProductUrlRule;
use Yii;
use yii\base\BootstrapInterface;
use product\assets\ProductAsset;
use yii\web\View;
use file\widgets\file_video_network\FileVideoNetworkWidget;

/**

 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2016 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 
 */
class Bootstrap implements BootstrapInterface {

    /**
     * Initial application compoments and modules need for extension
     * @param \yii\base\Application $app The application currently running
     * @return void
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            [
                'class' => ProductUrlRule::class,
                //'class' => UrlRule::class,
                //'pattern'=>"<url>",
                //'route'=>'/page/page/view-pattern',
            ],
        ], true);

        if (!isset($app->get('i18n')->translations['product*'])) {
            $app->get('i18n')->translations['product*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }

        $view = $app->view;
        if($app->view->bootstrapAssetBundles)
        {
            ProductAsset::register($view);
        }
    }
}
