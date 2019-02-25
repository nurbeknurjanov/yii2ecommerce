<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use eav\models\DynamicField;
use yii\test\ActiveFixture;
use Yii;

class DynamicFieldFixture extends ActiveFixture
{
    public $modelClass = DynamicField::class;
    public $depends = [CategoryFixture::class];

    public function getData()
    {
        return parent::getData();
    }
}