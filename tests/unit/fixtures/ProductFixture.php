<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use eav\models\DynamicField;
use product\models\InstagramModel;
use product\models\Product;
use product\models\ProductNetwork;
use yii\test\ActiveFixture;

class ProductFixture extends ActiveFixture
{
    public $modelClass = Product::class;
    public $depends = [
        UserFixture::class,
        CategoryFixture::class,
        ShopFixture::class,
    ];

    public function getData()
    {
        return parent::getData();
    }

    public function afterLoad()
    {
        parent::afterLoad();
        if(YII_ENV_PROD)
        {
            /*
            $app = \Yii::$app;
            if (!isset($app->get('i18n')->translations['product*']))
                $app->get('i18n')->translations['product*'] = [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => __DIR__ . '/messages',
                ];

            $product = Product::findOne(1);
            ProductNetwork::deleteAll();
            InstagramModel::removeAll();

            $response = InstagramModel::create($product);
            ProductNetwork::createOrUpdate($product, ProductNetwork::NETWORK_TYPE_INSTAGRAM, $response->getMedia()->getId(), $response->getMedia()->getCode());
            */
        }
    }
}