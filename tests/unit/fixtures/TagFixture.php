<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use tag\models\Tag;
use yii\test\ActiveFixture;
use Yii;

class TagFixture extends ActiveFixture
{
    public $modelClass = Tag::class;
}