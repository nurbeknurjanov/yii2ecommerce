<?php

/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace order\models;

use Yii;
use yii\web\Cookie;


class OrderLocal
{
    

    public static function create(Order $model)
    {
        $orders = self::findAll();
        $orders[$model->id]=[
            'id'=>$model->id,
            'created_at'=>$model->created_at,
        ];
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'orders',
            'value' => $orders,
            'expire' => time() + 3600*24*7,
        ]));
    }


    public static function findAll()
    {
        $orders = Yii::$app->response->cookies->get('orders')?:Yii::$app->request->cookies->get('orders');
        return $orders ? $orders->value:[];
    }
}