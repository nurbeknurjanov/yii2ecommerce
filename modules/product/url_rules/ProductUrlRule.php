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
            $product_title_url = isset($params['product_title_url']) ? $params['product_title_url']:null;
            if($product_title_url){
                $url = $product_title_url."-".$params['id'];

                unset($params['product_title_url']);
                unset($params['id']);

                if($params)
                    $url.="?".http_build_query($params);
                return $url;
            }
        }
        return false;
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = trim($request->getPathInfo(), '/');
        if($pathInfo = explode("-", $pathInfo)){
            $last = $pathInfo[count($pathInfo)-1];
            if($last && is_numeric($last)){
                $params = $_GET;
                $params['id'] = $last;
                return ['product/product/view', $params ];
            }
        }
        return false;
    }
}