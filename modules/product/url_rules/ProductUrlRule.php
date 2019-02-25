<?php

/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 9/23/16
 * Time: 10:20 AM
 */
namespace product\url_rules;

use page\models\Page;
use yii\base\Component;
use yii\web\UrlRuleInterface;

class ProductUrlRule extends Component implements UrlRuleInterface
{

    public function createUrl($manager, $route, $params)
    {
        if ($route === 'product/product/view') {
            if (isset($params['title_url']) && $params['title_url']){
                $title_url = $params['title_url'];
                $id = $params['id'];
                unset($params['title_url']);
                unset($params['id']);
                if(!$params)
                    return $title_url."-".$id;
                return $title_url."-".$id."?".http_build_query($params);
            }else{
                unset($params['title_url']);
                return $route."?".http_build_query($params);
            }
        }
        return false;
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        $pathInfo = trim($pathInfo, '/');

        if(strpos($pathInfo, 'upload')!==false)
            return false;

        $pathInfo = explode("-", $pathInfo);
        if($pathInfo){
            $last = $pathInfo[count($pathInfo)-1];
            if($last && is_numeric($last)){
                //echo 'product<br>';
                $params = $_GET;
                $params['id'] = $last;
                return ['product/product/view', $params ];
            }
        }
        return false;
    }
}