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
            if(!isset($params['category_id'])){
                if(!$params)
                    return "products";
                return "products?".http_build_query($params);
            }

            if (isset($params['title_url']) && $params['title_url']) {
                $title_url = $params['title_url'];
                unset($params['title_url']);
                unset($params[(new ProductSearchFrontend)->formName()]['category_id']);
                unset($params['category_id']);
                if(!$params)
                    return $title_url;
                return $title_url."?".http_build_query($params);
            }else{
                unset($params['title_url']);
                return "products?".http_build_query($params);
                //return $route."?".http_build_query($params);
            }
        }
        return false;
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        $pathInfo = trim($pathInfo, '/');
        if($pathInfo){

            if(strpos($pathInfo, 'upload')!==false)
                return false;

            if($pathInfo=='products')
                return ['product/product/list', $_GET];

            $firstPath = explode('/',$pathInfo)[0];
            if($firstPath=='site')
                return false;
            $moduleIDs = array_keys(Yii::$app->modules);
            if(in_array($firstPath, $moduleIDs))
                return false;

            if($category = Category::findOne(['title_url'=>$pathInfo])){
                $params = $_GET;
                //$params['title_url'] = $category->title_url;
                if($formName = (new ProductSearchFrontend())->formName()){
                    $params[$formName]['category_id'] = $category->id;
                    $params[$formName]['title_url'] = $category->title_url;
                }
                else{
                    $params['category_id'] = $category->id;
                    $params['title_url'] = $category->title_url;
                }
                return ['product/product/list', $params];
            }
        }

        return false;
    }
}