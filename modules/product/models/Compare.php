<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace product\models;

use Yii;

class Compare
{

    public static function getCount()
    {
        return count(self::findAll());
    }
    public static function getNProducts()
    {
        return Yii::t('order', '{n, plural, =0{no products} =1{# product} other{# products}}', ['n'=>self::getCount()]);
    }


    public static function delete($model_id)
    {
        $compareProducts = self::findAll();
        unset($compareProducts[$model_id]);
        Yii::$app->response->cookies->add(Yii::$container->get('cookie', [],  ['name'=>'compareProducts', 'value'=>$compareProducts]));
    }

    public static function create(Product $model)
    {
        $compareProducts = self::findAll();
        $compareProducts[$model->id]=$model->id;
        Yii::$app->response->cookies->add(Yii::$container->get('cookie', [],  ['name'=>'compareProducts', 'value'=>$compareProducts]));
    }


    public static function findAll()
    {
        $compareCookie = Yii::$app->response->cookies->get('compareProducts')
        ?:Yii::$app->request->cookies->get('compareProducts');
        return $compareCookie ? $compareCookie->value:[];
    }
}