<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace common\assets;

use Yii;
use yii\web\AssetBundle;

class BootboxAsset extends AssetBundle
{

    public $sourcePath = '@vendor/bower-asset/bootbox';
    public $js = [
        'bootbox.js',
    ];


    /*    public $basePath = '@webroot';
        public $baseUrl = '@web';
        public $js = [
            'static/plugins/bootbox.js',
        ];*/

    public static function register($view)
    {
        self::overrideSystemConfirm();
        return parent::register($view);
    }
    public static function overrideSystemConfirm()
    {
        Yii::$app->view->registerJs('
            yii.confirm = function(message, ok, cancel) {
                bootbox.confirm(message, function(result) {
                    if (result) {  !ok || ok(); } else { !cancel || cancel(); }
                });
            }
        ');
        /*
        Yii::$app->view->registerJs("
            yii.confirm = function(message, ok, cancel) {
                bootbox.confirm({
                                    buttons: {
                                            cancel: {
                                                    label: 'Отмена',
                                                    //className: 'cancel-button-class'
                                                },
                                            confirm: {
                                                label: 'Применить',
                                                //className: 'confirm-button-class'
                                            }
                                        },
                                    message: message,
                                    callback: function(result) {
                                        if (result) {  !ok || ok(); } else { !cancel || cancel(); }
                                    },
                                    //title: \"You can also add a title\",
                                });
            }
        ");
        */

        if(Yii::$app->sourceLanguage!=Yii::$app->language)
            Yii::$app->view->registerJs('
            bootbox.setDefaults({
                                    locale: "'.Yii::$app->language.'"
                                    });
        ');
        Yii::$app->view->registerJs('
            $(document).on(\'click\', \'.modal-backdrop, .bootbox\', function (event) {
                bootbox.hideAll()
            });
        ');
    }
}