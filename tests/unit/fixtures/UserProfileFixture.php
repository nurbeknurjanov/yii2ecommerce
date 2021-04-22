<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use user\models\UserProfile;
use yii\test\ActiveFixture;
use Yii;
use console\controllers\RbacInitController;

class UserProfileFixture extends ActiveFixture
{
    public $modelClass = UserProfile::class;
    public $depends = [UserFixture::class];
}