<?php

use user\models\User;
use yii\helpers\Html;
use eav\models\DynamicField;
use tests\unit\fixtures\CategoryFixture;
use extended\helpers\Helper;
use product\models\Product;
use tests\unit\fixtures\DynamicFieldFixture;
use tests\unit\fixtures\DynamicValueFixture;
use eav\models\DynamicValue;
use product\models\search\ProductSearchFrontend;
use tests\unit\fixtures\ProductFixture;
use order\models\Basket;
use order\models\OrderProduct;
use favorite\models\FavoriteLocal;
use favorite\models\Favorite;
use yii\base\Exception;
use product\models\Compare;

class CompareTest extends \Codeception\Test\Unit
{
    //use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;


    public function _fixtures()
    {
        return [
            'categories' => [
                'class' => CategoryFixture::class,
                'dataFile' => __DIR__ .'/test_fixtures/data/category.php',
                'depends'=>[],
            ],
            'products' => [
                'class' => ProductFixture::class,
                'dataFile' => __DIR__.'/test_fixtures/data/product.php',
                'depends'=>[],
            ],
        ];
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testCompareAdd()
    {
        $product = $this->tester->grabFixture('products', 0);

        Compare::create($product);

        $this->tester->assertEquals(1, Compare::getCount());
        $this->tester->assertEquals(1, Product::find()->compare()->count());
    }
    public function testCompareRemove()
    {
        $product = $this->tester->grabFixture('products', 0);
        $this->testCompareAdd();
        Compare::delete($product->id);
        $this->tester->assertEquals(0, Compare::getCount());
        $this->tester->assertEquals(0, Product::find()->compare()->enabled()->with("valuesWithFields")->count());

    }

}