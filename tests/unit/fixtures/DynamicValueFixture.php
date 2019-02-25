<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use eav\models\DynamicValue;
use yii\test\ActiveFixture;

class DynamicValueFixture extends ActiveFixture
{
    public $modelClass = DynamicValue::class;
    public $depends = [
        DynamicFieldFixture::class,
        ProductFixture::class,
    ];
}