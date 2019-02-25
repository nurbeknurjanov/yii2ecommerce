<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use category\models\Category;
use yii\test\ActiveFixture;
use Yii;

class CategoryFixture extends ActiveFixture
{

    public $modelClass = Category::class;
    //public $dataFile=__DIR__.'/../test_fixtures/category.php';

    public function getData()
    {
        return parent::getData();
    }

    public function afterLoad()
    {
        parent::afterLoad();

        Yii::$app->cache->flush();
    }
}