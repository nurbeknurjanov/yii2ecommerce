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

class BasketTest extends \Codeception\Test\Unit
{
    //use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;


    public function _fixtures()
    {
        return [
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

    public function testBasketAdd()
    {
        $product = $this->tester->grabFixture('products', 0);

        Basket::create(new OrderProduct([
            'product_id'=>$product->id,
            'price'=>$product->price,
            'count'=>1,
        ]));
        $this->tester->assertEquals(1, Basket::getCount());
    }
    public function testBasketUpdate()
    {
        $product = $this->tester->grabFixture('products', 0);
        $this->testBasketAdd();
        Basket::update(new OrderProduct([
            'product_id'=>$product->id,
            'price'=>$product->price,
            'count'=>2,
        ]));
        $this->tester->assertEquals(2*$product->price, Basket::getAmount());
    }
    public function testBasketRemove()
    {
        $product = $this->tester->grabFixture('products', 0);
        $this->testBasketAdd();
        Basket::delete($product->id);
        $this->tester->assertEquals(0, Basket::getCount());
    }

}