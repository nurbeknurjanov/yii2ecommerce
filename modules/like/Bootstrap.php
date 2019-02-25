<?php

namespace like;

use Yii;
use yii\base\BootstrapInterface;
use like\assets\LikeAsset;

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

        if($app->id!='app-console')
            Yii::$app->view->registerAssetBundle(LikeAsset::class);

        if (!isset(Yii::$app->get('i18n')->translations['like*'])) {
            Yii::$app->get('i18n')->translations['like*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }
}
