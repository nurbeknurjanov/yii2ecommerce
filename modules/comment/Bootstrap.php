<?php

namespace comment;

use article\assets\ArticleAsset;
use Yii;
use yii\base\BootstrapInterface;

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


        if (!isset(Yii::$app->get('i18n')->translations['comment*'])) {
            Yii::$app->get('i18n')->translations['comment*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }

        if($app->view->bootstrapAssetBundles){
            Yii::$app->view->registerAssetBundle(ArticleAsset::class);
        }
    }
}
