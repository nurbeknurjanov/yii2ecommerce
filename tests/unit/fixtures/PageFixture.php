<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use page\models\Page;
use yii\test\ActiveFixture;
use Yii;

class PageFixture extends ActiveFixture
{
    public $modelClass = Page::class;
}