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

class FavoriteTest extends \Codeception\Test\Unit
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

    public function testFavoriteAdd()
    {
        $product = $this->tester->grabFixture('products', 0);

        $model = new Favorite;
        $model->trigger($model::EVENT_INIT);
        $model->model_name = $product::className();
        $model->model_id = $product->id;

        if($model->validate()){
            FavoriteLocal::create($model);
        }else {
            throw new Exception(Html::errorSummary($model));
        }

        $this->tester->assertEquals(1, FavoriteLocal::getCount());
        $this->tester->assertEquals(1, Product::find()->favorite()->count());

    }
    public function testFavoriteRemove()
    {
        $product = $this->tester->grabFixture('products', 0);
        $this->testFavoriteAdd();
        FavoriteLocal::delete($product::className(), $product->id);
        $this->tester->assertEquals(0, FavoriteLocal::getCount());
        $this->tester->assertEquals(0, Product::find()->favorite()->count());

    }

}