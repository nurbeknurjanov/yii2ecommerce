<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use like\models\Like;
use yii\test\ActiveFixture;
use Yii;

class LikeFixture extends ActiveFixture
{
    public $modelClass = Like::class;
    public $depends = [CommentFixture::class];
}