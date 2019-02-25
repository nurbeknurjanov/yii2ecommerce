<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace product\models;

use Yii;
use yii\web\Cookie;

class Viewed
{
    public static function create($id)
    {
        $viewedProducts = self::findAll();
        $viewedProducts[$id]=[
            'id'=>$id,
            'date'=>date("Y-m-d H:i:s"),
        ];
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'viewedProducts',
            'value' => $viewedProducts,
            'expire' => time() + 3600*24*7,
        ]));
    }

    public static function clearAll()
    {
        Yii::$app->response->cookies->remove('viewedProducts');
    }
    public static function findAll()
    {
        $viewedProductsCookie =
            Yii::$app->response->cookies->get('viewedProducts')?
                :Yii::$app->request->cookies->get('viewedProducts');
        return $viewedProductsCookie ? $viewedProductsCookie->value:[];
    }
}