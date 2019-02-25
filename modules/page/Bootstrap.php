<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace page;

use page\models\Page;
use page\url_rules\PageUrlRule;
use Yii;
use yii\base\BootstrapInterface;
use yii\web\UrlRule;
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
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            [
                'class' => PageUrlRule::class,
                //'class' => UrlRule::className(),
                //'pattern'=>"<url>",
                //'route'=>'/page/page/view-pattern',
            ],
        ], true);

        if (!isset(Yii::$app->get('i18n')->translations['page*'])) {
            Yii::$app->get('i18n')->translations['page*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }

        $view = $app->view;

        if(!$app->request->isConsoleRequest && $app->id!='app-backend' &&
            !$app->request->isAjax )
            $view->on(View::EVENT_END_BODY, function () use ($view) {
                echo $view->render('@page/views/help/_fixed_help');
            });

    }
}
