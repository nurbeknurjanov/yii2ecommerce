<?php

namespace tests\acceptance;

use yii\helpers\Html;
use yii\helpers\Url;
use tests\unit\fixtures\ProductFixture;
use tests\unit\fixtures\CategoryFixture;
use order\models\OrderProduct;
use order\models\Order;
use product\models\Product;
use Yii;
use AcceptanceTester;
use tests\unit\fixtures\ProductBuyWithThisFixture;
use tests\unit\fixtures\UserFixture;
use tests\unit\fixtures\DynamicFieldFixture;
use tests\unit\fixtures\DynamicValueFixture;

class ProductCest
{
    public function _fixtures()
    {
        $fixtures = [
            'categories' => [
                'class' => CategoryFixture::class,
                'dataFile' => __DIR__ . '/../unit/test_fixtures/data/category.php',
                'depends'=>[],
            ],
            'products' => [
                'class' => ProductFixture::class,
                'dataFile' => __DIR__ . '/../unit/test_fixtures/data/product.php',
                'depends'=>[],
            ],
            'dynamic_fields' => [
                'class' => DynamicFieldFixture::class,
                'dataFile' => __DIR__ . '/../unit/test_fixtures/data/dynamic_field.php',
                'depends' => [],
            ],
            'dynamic_values'=>[
                'class' => DynamicValueFixture::class,
                'dataFile' => __DIR__ . '/../unit/test_fixtures/data/dynamic_value.php',
                'depends' => [],
            ],
            'users' => [
                'class' => UserFixture::class,
                'depends'=>[],
            ],
        ];
        return $fixtures;
    }

    public function _before(AcceptanceTester $I)
    {
        if($I->getScenario()->getFeature()=='check buy with this'){
            $I->haveFixtures([
                'check_buy_with_this'=>[
                    'class' => ProductBuyWithThisFixture::class,
                    'depends'=>[],
                ]
            ]);
        }
    }
    public function _after(AcceptanceTester $I)
    {
    }

    public function checkBuyWithThis(AcceptanceTester $I)
    {
        $bag = $I->grabFixture('products', 4);
        $I->goToProduct($I, $I->grabFixture('products', 0));
        $I->see($bag->title);
    }

    public function checkType(AcceptanceTester $I)
    {

        $product = new Product;
        $asus = $I->grabFixture('products', 0);
        $bag = $I->grabFixture('products', 4);

        $I->amOnPage(Url::to(['/product/product/type', 'type'=>Product::TYPE_PROMOTE]));
        $product->type = Product::TYPE_PROMOTE;
        $I->waitForText($product->typeText, null, 'h1');
        $I->see($asus->title);
        $I->dontSee($bag->title);

        $I->amOnPage(Url::to(['/product/product/type', 'type'=>Product::TYPE_POPULAR]));
        $product->type = Product::TYPE_POPULAR;
        $I->waitForText($product->typeText, null, 'h1');
        $I->see($asus->title);
        $I->dontSee($bag->title);

        $I->amOnPage(Url::to(['/product/product/type', 'type'=>Product::TYPE_NOVELTY]));
        $product->type = Product::TYPE_NOVELTY;
        $I->waitForText($product->typeText, null, 'h1');
        $I->see($asus->title);
        $I->dontSee($bag->title);


        $I->amOnPage(Yii::$app->homeUrl);
        $I->waitForText($asus->title,null, 'h1');
        $I->dontSee($bag->title, 'h1');
        $I->seeNumberOfElements("#showBasket-".$asus->id,2);
        $I->dontSeeElement("#showBasket-".$bag->id);
    }
    protected function checkViewedProducts(AcceptanceTester $I)
    {
        $I->goToProduct($I, $I->grabFixture('products', 0));

        $I->amOnPage(Url::to(['/product/product/viewed']));
        $asus = $I->grabFixture('products', 0);
        $I->waitForText($asus->title);
    }


    protected function testGrouped(AcceptanceTester $I)
    {
        $fanta = $I->grabFixture('products', 2);
        $fantaBig = $I->grabFixture('products', 3);

        $I->amOnPage(Url::to(Yii::$app->homeUrl));
        $I->goToCategory($I, $I->grabFixture('categories', 0));

        $I->cantSee($fantaBig->title);
        $I->see($fanta->title);
    }

    public function whenCategoryIsNull(AcceptanceTester $I, \Helper\Acceptance $helper)
    {
        $I->amOnPage(Url::to(['/product/product/list']));
        $asus = $I->grabFixture('products', 0);
        $I->seeLink($asus->title);
    }
    public function whenCategoryIsWrong(AcceptanceTester $I, \Helper\Acceptance $helper)
    {
        $helper->goToCategory($I, $I->grabFixture('categories', 1));
        $asus = $I->grabFixture('products', 0);
        $I->dontSeeLink($asus->title);
    }
    public function whenCategoryIsRight(AcceptanceTester $I, \Helper\Acceptance $helper)
    {
        $helper->goToCategory($I, $I->grabFixture('categories', 0));
        $asus = $I->grabFixture('products', 0);
        $I->seeLink($asus->title);
    }
    public function whenCategoryIsRightAndWrongOption(AcceptanceTester $I, \Helper\Acceptance $helper)
    {
        //write category & wrong option
        $helper->goToCategory($I, $I->grabFixture('categories', 0));
        $asus = $I->grabFixture('products', 0);
        $processor = $I->grabFixture('dynamic_fields', 0);
        $i3 = $I->grabFixture('dynamic_values', 0)->value;
        $i5='i5';


        $I->see($processor->label);
        //$I->selectOption("[name=$processor->key]", $i3);
        $I->checkOption("[name='processor[]'][value=$i5]");
        $I->wait(1);
        $I->seeInCurrentUrl("$processor->key=$i5");
        $I->seeCheckboxIsChecked("[name='processor[]'][value=$i5]");
        $I->dontSeeLink($asus->title);

        $I->uncheckOption("[name='processor[]'][value=$i5]");
        $I->checkOption("[name='processor[]'][value=$i3]");
        $I->wait(1);
        $I->seeInCurrentUrl("$processor->key=$i3");
        $I->seeCheckboxIsChecked("[name='processor[]'][value=$i3]");
        $I->dontSeeCheckboxIsChecked("[name='processor[]'][value=$i5]");
        $I->seeLink($asus->title);

        $I->fillField("priceFrom", 800);
        $I->fillField("priceTo", 600);
        $I->wait(1);
        $I->seeInCurrentUrl("priceFrom=800");
        $I->seeInCurrentUrl("priceTo=600");
        $I->seeInField('priceFrom', 800);
        $I->seeInField('priceTo', 600);
        $I->dontSeeLink($asus->title);

        $I->fillField("priceFrom", 700);
        $I->fillField("priceTo", 1000);
        $I->wait(1);
        $I->seeInCurrentUrl("priceFrom=700");
        $I->seeInCurrentUrl("priceTo=1000");
        $I->seeInField('priceFrom', 700);
        $I->seeInField('priceTo', 1000);
        $I->seeLink($asus->title);


        $I->fillField('q', 'good asus');
        $I->click('#textSearchForm button');
        $sub_text = Yii::t('product', '{n, plural, =0{no products} =1{# product} other{# products}} found.',
            ['n'=>Product::find()->joinWith('values')->whereByQ($I->grabValueFrom('q'))->count()]);
        $this->title = Yii::t('product',
            'For query "{q}" - {sub_text}',
            ['sub_text'=>$sub_text, 'q'=>$I->grabValueFrom('q')]);
        $I->waitForText($this->title);
        $I->seeLink($asus->title);

        $I->fillField('q', 'asus1');
        $I->click('#textSearchForm button');
        $sub_text = Yii::t('product', '{n, plural, =0{no products} =1{# product} other{# products}} found.',
            ['n'=>Product::find()->joinWith('values')->whereByQ($I->grabValueFrom('q'))->count()]);
        $this->title = Yii::t('product',
            'For query "{q}" - {sub_text}',
            ['sub_text'=>$sub_text, 'q'=>$I->grabValueFrom('q')]);
        $I->waitForText($this->title);
        $I->dontSeeLink($asus->title);
    }

}
