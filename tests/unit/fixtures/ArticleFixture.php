<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use article\models\Article;
use yii\test\ActiveFixture;

class ArticleFixture extends ActiveFixture
{
    public $modelClass = Article::class;
}