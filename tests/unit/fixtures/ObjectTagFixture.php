<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use tag\models\ObjectTag;
use yii\test\ActiveFixture;
use Yii;

class ObjectTagFixture extends ActiveFixture
{
    public $modelClass = ObjectTag::class;
    public $depends = [TagFixture::class, ArticleFixture::class];
}