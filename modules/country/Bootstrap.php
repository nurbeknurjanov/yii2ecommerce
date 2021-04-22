<?php

namespace country;

use article\assets\ArticleAsset;
use product\url_rules\ProductUrlRule;
use Yii;
use yii\base\BootstrapInterface;
use country\assets\CountryAsset;

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
    public function bootstrap($app) {

        if (!isset(Yii::$app->get('i18n')->translations['country*'])) {
            Yii::$app->get('i18n')->translations['country*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }
        if($app->view->bootstrapAssetBundles){
            Yii::$app->view->registerAssetBundle(CountryAsset::class);
        }
    }
}
