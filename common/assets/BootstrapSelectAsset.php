<?php

namespace common\assets;

use yii\web\AssetBundle;
use yii\helpers\ArrayHelper;
use Yii;
use cakebake\bootstrap\select\BootstrapSelectAsset as BSA;

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
class BootstrapSelectAsset extends AssetBundle
{
    public $sourcePath = '@common/bower/bootstrap-selectpicker';
    public $js = [
        'js/selectpicker.js',
    ];
    public $depends = [
        BSA::class
    ];
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

        if(Yii::$app->language=='ru'){
            list ($jsPath, $jsUrl) = $view->assetManager->publish((new BSA)->sourcePath.'/js/i18n/defaults-ru_RU.js');
            $view->registerJsFile( $jsUrl,['depends'=>get_called_class()]);
        }
    }


}