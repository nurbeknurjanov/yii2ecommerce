<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace extended\view;

use Yii;


class View extends \yii\web\View
{
    public function yieldContent($content)
    {
        preg_match_all('#{{(.*?)}}#is', $content, $output, PREG_PATTERN_ORDER);
        if(isset($output[1])){
            $sections = $output[1];
            foreach ($sections as $section){
                $content = str_replace("{{".$section."}}", isset($this->blocks[$section]) ? $this->blocks[$section]:null, $content);
                if(preg_match( '/\{\{(\w+)\}\}/', $content))
                    return $this->yieldContent($content);
            }
        }
        return $content;
    }
    public function clearAssetBundle($assetBundle)
    {
        unset($this->assetManager->bundles[$assetBundle], $this->assetBundles[$assetBundle]);
        Yii::$container->set($assetBundle,[
            'css'=>[],
            'js'=>[],
            'depends' => [
            ],
        ]);
    }

    public function init()
    {
        parent::init();
        if(Yii::$app->id=='app-api')
            return $this->bootstrapAssetBundles=false;
        if(Yii::$app->request->isConsoleRequest)
            return $this->bootstrapAssetBundles=false;
        if(Yii::$app->request->isAjax)
            return $this->bootstrapAssetBundles=false;
        $this->bootstrapAssetBundles=true;
    }

    public $bootstrapAssetBundles;
}