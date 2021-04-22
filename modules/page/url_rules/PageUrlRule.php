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
            $page_title_url = isset($params['page_title_url']) ? $params['page_title_url']:null;
            if($page_title_url){
                $url = $page_title_url;
                unset($params['page_title_url']);

                if($params)
                    $url.="?".http_build_query($params);
                return $url;
            }
        }
        return false;  // данное правило не применимо
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = trim($request->getPathInfo(), '/');
        if($pathInfo){

            if(strpos($pathInfo, 'upload')!==false)
                return false;

            $firstPath = explode('/',$pathInfo)[0];
            if($firstPath=='site')
                return false;
            $moduleIDs = array_keys(Yii::$app->modules);
            if(in_array($firstPath, $moduleIDs))
                return false;

            if($page = Page::findOne(['title_url'=>$pathInfo])){
                $params = $_GET;
                $params['id']=$page->id;
                $params['page_title_url']=$page->title_url;//need in menu item to be active
                if(Yii::$app->id=='app-api')
                    return ['page/view', $params ];
                return ['page/page/view', $params ];
            }
        }
        return false;
    }
}