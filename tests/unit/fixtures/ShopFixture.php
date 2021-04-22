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
use shop\models\Shop;
use yii\test\ActiveFixture;

class ShopFixture extends ActiveFixture
{
    public $modelClass = Shop::class;
    public $depends = [
        UserFixture::class,
    ];

    public function getData()
    {
        return parent::getData();
    }

    public function afterLoad()
    {
        parent::afterLoad();
    }
}