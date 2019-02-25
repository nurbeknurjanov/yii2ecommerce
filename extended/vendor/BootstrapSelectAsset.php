<?php

namespace extended\vendor;

use yii\web\AssetBundle;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
class BootstrapSelectAsset extends \cakebake\bootstrap\select\BootstrapSelectAsset
{


    public static function register($view, $options = [])
    {
        $o = ArrayHelper::merge([
            'selector' => '.selectpicker',
            'menuArrow' => false,
            'tickIcon' => true,
            'selectpickerOptions' => [
                'style' => 'btn-default form-control',
            ],
        ], $options);

        if (!is_string($o['selector']) || empty($o['selector']))
            return false;

        $js = '';

        if ($o['menuArrow']) {
            $js .= '$("' . $o['selector'] . '").addClass("show-menu-arrow");' . PHP_EOL;
        }

        if ($o['tickIcon']) {
            $js .= '$("' . $o['selector'] . '").addClass("show-tick");' . PHP_EOL;
        }

        //Enable Bootstrap-Select for $o['selector']
        $js .= '$("' . $o['selector'] . '").selectpicker(' . json_encode($o['selectpickerOptions']) . ');' . PHP_EOL;

        //Update Bootstrap-Select by :reset click
        $js .= '$(":reset").click(function(){
            $(this).closest("form").trigger("reset");
            $("' . $o['selector'] . '").selectpicker("refresh");
        });';


        $view->registerJs($js);

        if(isset($view->assetManager->bundles['all']))
            $view->clearAssetBundle(get_called_class());
        $bundle = $view->registerAssetBundle(get_called_class());
        if(Yii::$app->language!=Yii::$app->sourceLanguage){
            if(Yii::$app->language=='ru')
                $view->registerJsFile($bundle->baseUrl.'/js/i18n/defaults-ru_RU.js', ['depends'=>get_called_class()]);
        }
        return $bundle;
    }
}