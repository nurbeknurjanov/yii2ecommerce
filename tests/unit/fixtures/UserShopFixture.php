<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use shop\models\UserShop;
use tag\models\ObjectTag;
use yii\test\ActiveFixture;
use Yii;

class UserShopFixture extends ActiveFixture
{
    public $modelClass = UserShop::class;
    public $depends = [UserFixture::class, ShopFixture::class];
}