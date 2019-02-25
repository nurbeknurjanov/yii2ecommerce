<?php

namespace favorite;

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
        //Yii::setAlias("@product", __DIR__);

        if (!isset(Yii::$app->get('i18n')->translations['favorite*'])) {
            Yii::$app->get('i18n')->translations['favorite*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }
}
