<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace order\models;

use Yii;



class Basket
{
    public static function getNProducts()
    {
        return Yii::t('order', '{n, plural, =0{no products} =1{# product} other{# products}}', ['n'=>self::getCount()]);
    }
    public static function getNProductsForAmount()
    {
        return  Yii::t('order', "{nProducts} for {amount}",
            ['amount'=>Yii::$app->formatter->asCurrency(self::getAmount()), 'nProducts'=>self::getNProducts()]);
    }

    public static function getCount()
    {
        return count(self::findAll());
    }
    public static function getAmount()
    {
        $amount = 0;
        $basketProducts = self::findAll();
        if($basketProducts)
            foreach ($basketProducts as $basket)
                //$amount+=Product::findOne($basket['product_id'])->price *$basket['count'];
                $amount+=$basket['price']*$basket['count'];
        return $amount;
    }


    public static function deleteAll()
    {
        Yii::$app->response->cookies->remove('basketProducts');
    }
    public static function delete($product_id)
    {
        $basketProducts = self::findAll();
        unset($basketProducts[$product_id]);
        Yii::$app->response->cookies->add(Yii::$container->get('cookie', [],  ['name'=>'basketProducts', 'value'=>$basketProducts]));
    }


    public static function update(OrderProduct $orderProduct)
    {
        self::create($orderProduct);
    }

    public static function create(OrderProduct $orderProduct)
    {
        $basketProducts = self::findAll();
        $basketProducts[$orderProduct->product_id]=[
            'product_id'=>$orderProduct->product_id,
            'count'=>$orderProduct->count,
            'price'=>$orderProduct->price,
        ];
        Yii::$app->response->cookies->add(Yii::$container->get('cookie', [],   ['name'=>'basketProducts', 'value'=>$basketProducts]));

        /*Yii::$app->response->cookies->add(new Cookie([
            'name' => 'basketProducts',
            'value' => $basketProducts,
            'expire' => time() + 3600*24*7,
        ]));*/
    }

    public static function findAll()
    {
        $basketProducts = Yii::$app->response->cookies->get('basketProducts')?:Yii::$app->request->cookies->get('basketProducts');
        return $basketProducts ? $basketProducts->value:[];
    }

    public static function isEmpty()
    {
        return !Basket::findAll();
    }
    public static function isAlreadyInBasket(int $product_id)
    {
        $basketProducts = self::findAll();
        return isset($basketProducts[$product_id]);
    }
    public static function getProduct(int $product_id)
    {
        if(self::isAlreadyInBasket($product_id)){
            return self::findAll()[$product_id];
        }
    }
}