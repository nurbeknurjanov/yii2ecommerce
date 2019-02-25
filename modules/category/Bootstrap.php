<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace category;

use category\url_rules\CategoryUrlRule;
use product\url_rules\ProductUrlRule;
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
        /*$app->getUrlManager()->addRules([
            'products'=>"product/product/list"
        ], true);*/
        $app->getUrlManager()->addRules([
            [
                'class' => CategoryUrlRule::class,
                //'class' => UrlRule::class,
                //'pattern'=>"<url>",
                //'route'=>'/page/page/view-pattern',
            ],
        ], true);

        if (!isset(Yii::$app->get('i18n')->translations['category*'])) {
            Yii::$app->get('i18n')->translations['category*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }
}
