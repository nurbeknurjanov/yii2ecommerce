<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use comment\models\Comment;
use yii\test\ActiveFixture;
use Yii;

class CommentFixture extends ActiveFixture
{
    public $modelClass = Comment::class;
    public $depends = [ProductFixture::class];
}