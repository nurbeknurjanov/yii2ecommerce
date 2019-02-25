<?php 

namespace johnitvn\ajaxcrud;

use yii\web\AssetBundle;

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2016 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 * @since 1.0
 */
class CrudAsset extends AssetBundle
{
    public $sourcePath = '@ajaxcrud/assets';

//    public $publishOptions = [
//        'forceCopy' => true,
//    ];

    public $css = [
        'ajaxcrud.css'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'kartik\grid\GridViewAsset',
    ];
    
   public function init() {
       // In dev mode use non-minified javascripts
       $this->js = YII_DEBUG ? [
           'ModalRemote.js',
           'ajaxcrud.js',
           'tree.js',
       ]:[
           'ModalRemote.min.js',
           'ajaxcrud.min.js',
           'tree.js',
       ];

       parent::init();
   }
}
