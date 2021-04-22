<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\assets;

use kartik\rating\StarRating;
use yii\helpers\Url;
use yii\web\AssetBundle;
use Yii;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CommonAsset extends AssetBundle
{
    public $sourcePath = '@common/asset_source';
    public $css = [
        'css/common.css',
    ];
    public $js = [
        'js/url.js',
        'js/star-rating.js',
        'js/functions.js',
        'js/common.js',
        'js/re-captcha.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'kartik\rating\StarRatingAsset',
    ];

    public $publishOptions = [
        //'forceCopy' => !YII_ENV_PROD,
        'only' => [
            'css/*',
            'js/*',
            'images/*',
        ]
    ];
    public static function register($view)
    {
        $baseUrlWithLanguage = Url::to(['/']);
        if($baseUrlWithLanguage=='/')
            $baseUrlWithLanguage = '';//так надо, а иначе на английском будет /+/site/index два // будет
        $cleanBaseUrl = str_replace('/'.Yii::$app->language, '', $baseUrlWithLanguage);
        Yii::$app->view->registerJs("
            var baseUrl = '".$cleanBaseUrl."';
            var baseUrlWithLanguage = '".$baseUrlWithLanguage."';
            
            /*$(document).on('pjax:complete', function() {
                
            });*/
            
        ", View::POS_HEAD);
        return parent::register($view);
    }
}
