<?php

namespace user;

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
    public function bootstrap($app)
    {
        // Set alias for extension source
        Yii::setAlias('@delivery', __DIR__. '/modules/delivery');
        Yii::setAlias('@user_manage', __DIR__. '/modules/manage');


        // Setup i18n compoment for translate all category user*
        if (!isset(Yii::$app->get('i18n')->translations['user*'])) {
            Yii::$app->get('i18n')->translations['user*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'forceTranslation'=>true,
                //'basePath' =>'@user/messages',
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }
}
