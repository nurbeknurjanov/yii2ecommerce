<?php

/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace favorite\models;

use Yii;
use yii\web\Cookie;


class FavoriteLocal
{

    public static function getCount()
    {
        return count(self::findAll());
    }
    public static function getNProducts()
    {
        return Yii::t('order', '{n, plural, =0{no products} =1{# product} other{# products}}', ['n'=>self::getCount()]);
    }

    public static function delete($model_name, $model_id)
    {
        $favoriteProducts = self::findAll();
        unset($favoriteProducts[$model_name.'|'.$model_id]);
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'favoriteProducts',
            'value' => $favoriteProducts,
            'expire' => time() + 3600*24*7,
        ]));
    }

    public static function create(Favorite $model)
    {
        $favoriteProducts = self::findAll();
        $favoriteProducts[$model->model_name.'|'.$model->model_id]=[
            'model_id'=>$model->model_id,
            'model_name'=>$model->model_name,
            'user_id'=>$model->user_id,
            'created_at'=>$model->created_at,
        ];
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'favoriteProducts',
            'value' => $favoriteProducts,
            'expire' => time() + 3600*24*7,
        ]));
    }


    public static function findAll()
    {
        $favoriteProducts = Yii::$app->response->cookies->get('favoriteProducts')?Yii::$app->response->cookies->get('favoriteProducts'):Yii::$app->request->cookies->get('favoriteProducts');
        return $favoriteProducts ? $favoriteProducts->value:[];
    }
}