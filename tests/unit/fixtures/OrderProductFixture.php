<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use order\models\OrderProduct;
use yii\test\ActiveFixture;
use Yii;

class OrderProductFixture extends ActiveFixture
{
    public $modelClass = OrderProduct::class;
    public $depends = [
        ProductFixture::class,
        OrderFixture::class
    ];
}