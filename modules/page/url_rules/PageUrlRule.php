<?php

/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 9/23/16
 * Time: 10:20 AM
 */
namespace page\url_rules;

use page\models\Page;
use yii\web\UrlRuleInterface;
use yii\base\Component;
use Yii;

class PageUrlRule extends Component implements UrlRuleInterface
{

    public function createUrl($manager, $route, $params)
    {
        if ($route === 'page/page/view') {
            if (isset($params['url']) && $params['url']) {
                $url = $params['url'];
                unset($params['url']);
                unset($params['id']);
                if(!$params)
                    return $url;
                return $url."?".http_build_query($params);
            }else{
                unset($params['url']);
                return $route."?".http_build_query($params);
            }
        }
        return false;  // данное правило не применимо
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        $pathInfo = trim($pathInfo, '/');
        if($pathInfo){

            if(strpos($pathInfo, 'upload')!==false)
                return false;

            $firstPath = explode('/',$pathInfo)[0];
            if($firstPath=='site')
                return false;
            $moduleIDs = array_keys(Yii::$app->modules);
            if(in_array($firstPath, $moduleIDs))
                return false;


            //echo 'page<br>';
            if($page = Page::find()->where(['url'=>$pathInfo])->one()){
                $params = $_GET;
                $params['id']=$page->id;
                $params['url']=$page->url;//need in menu item to be active
                if(Yii::$app->id=='app-api')
                    return ['page/view', $params ];
                return ['page/page/view', $params ];
            }
        }
        return false;
    }
}