<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use product\models\Rating;
use yii\test\ActiveFixture;
use Yii;

class RatingFixture extends ActiveFixture
{
    public $modelClass = Rating::class;
    public $depends = [ProductFixture::class, CommentFixture::class];
    public $dataDirectory=__DIR__.'/data';
    public $dataFile='comment_rating.php';
}