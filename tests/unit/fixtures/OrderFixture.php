<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use order\models\Order;
use yii\test\ActiveFixture;
use Yii;

class OrderFixture extends ActiveFixture
{
    public $modelClass = Order::class;

    public function getData()
    {
        return parent::getData();
    }
}