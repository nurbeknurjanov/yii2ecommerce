<?php

namespace order;

use order\assets\OrderAsset;
use Yii;
use yii\base\BootstrapInterface;
use yii\web\View;


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

        $view = Yii::$app->view;

        if (!isset(Yii::$app->get('i18n')->translations['order*'])) {
            Yii::$app->get('i18n')->translations['order*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }

        if($app->view->bootstrapAssetBundles)
        {
            OrderAsset::register($view);
            if(!in_array($app->id, ['app-backend', 'app-frontend-app']))
                $view->on(View::EVENT_END_BODY, function () use ($view) {
                    echo $view->render('@order/views/order/_basket_modal');
                });
        }

    }
}
