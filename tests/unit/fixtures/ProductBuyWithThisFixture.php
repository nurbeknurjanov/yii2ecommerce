<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use product\models\ProductBuyWithThis;
use yii\test\ActiveFixture;

class ProductBuyWithThisFixture extends ActiveFixture
{
    public $modelClass = ProductBuyWithThis::class;
    public $depends = [
        ProductFixture::class,
    ];
}