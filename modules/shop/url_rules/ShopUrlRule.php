<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace shop\url_rules;

use yii\base\Component;
use yii\web\UrlRuleInterface;
use yii\helpers\Url;
use Yii;
use shop\models\Shop;

class ShopUrlRule extends Component implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params)
    {
        if ($route === 'shop/shop/view' && isset($params['title_url'])) {
            $url = $params['title_url'];
            unset($params['title_url']);
        }

        if(isset($url)){
            if($params)
                $url.= '?'.http_build_query($params);
            return $url;
        }
        return false;
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = trim($request->getPathInfo(), '/');
        $parts = explode('/', $pathInfo);

        if($pathInfo){


            if(isset($parts[0]) && $parts[0] && $shop = Shop::findOne(['title_url'=>$parts[0]])){
                $_GET['id'] = $shop->id;

                return ['shop/shop/view', $_GET];
            }

        }

        return false;
    }
}