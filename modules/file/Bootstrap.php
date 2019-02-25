<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file;

use file\assets\FileAsset;
use file\widgets\file_video_network\FileVideoNetworkWidget;
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
        $view = $app->view;
        FileAsset::register($view);

        if (!isset(Yii::$app->get('i18n')->translations['file*'])) {
            Yii::$app->get('i18n')->translations['file*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }

        if(!Yii::$app->request->isAjax)
            $view->on(View::EVENT_END_BODY, function () use ($view) {
                echo FileVideoNetworkWidget::widget();
            });
    }
}
