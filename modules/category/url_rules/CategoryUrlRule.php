<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace category\url_rules;

use category\models\Category;
use product\models\search\ProductSearchFrontend;
use yii\base\Component;
use yii\web\UrlRuleInterface;
use yii\helpers\Url;
use Yii;

class CategoryUrlRule extends Component implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params)
    {
        if ($route === 'product/product/list') {
            $url = "products";

            $category_title_url = isset($params['category_title_url']) ? $params['category_title_url']:null;
            unset($params['category_title_url']);
            unset($params[(new ProductSearchFrontend)->formName()]['category_id']);
            unset($params['category_id']);
            if($category_title_url)
                $url = $category_title_url;

            if($params)
                $url.= '?'.http_build_query($params);
            return $url;
        }
        return false;
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

            if($pathInfo=='products')
                return ['product/product/list', $_GET];

            if($category = Category::findOne(['title_url'=>$pathInfo])){
                $params = $_GET;
                if($formName = (new ProductSearchFrontend())->formName())
                    $params[$formName]['category_id'] = $category->id;
                else
                    $params['category_id'] = $category->id;

                $params['category_title_url'] = $category->title_url;

                if(Yii::$app->id=='app-api')
                    return ['product/index', $params ];
                return ['product/product/list', $params];
            }
        }

        return false;
    }
}