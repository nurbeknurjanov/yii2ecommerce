<?php

namespace tests\acceptance;

use yii\helpers\Url;
use tests\unit\fixtures\ProductFixture;
use tests\unit\fixtures\CategoryFixture;
use order\models\OrderProduct;
use order\models\Order;
use product\models\Product;
use Yii;
use AcceptanceTester;
use yii\helpers\Html;
use product\models\Compare;

class FavoriteCest
{
    public function _fixtures()
    {
        return [
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
        ];
    }

    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }


    public function testRemoveFavorite(AcceptanceTester $I)
    {
        $this->testAddFavorite($I);
        $product = $I->grabFixture('products', 0);

        $I->amOnPage(Url::to($product->url));

        $add = '.addToFavorite';
        $remove = '.removeFromFavorite';
        $I->waitForElement($remove);
        $I->seeElement($remove);
        $I->dontSeeElement($add);
        $I->click($remove);
        $I->waitForElement($add);
        $I->dontSeeElement($remove);

        /*$text = Yii::t('product', 'Comparing products').'('.Html::tag('span',
                Yii::t('order', '{n, plural, =0{no products} =1{# product} other{# products}}', ['n'=>0])
                , ['id'=>'compareCountSpan',]).')';*/
        $text = Yii::t('order', '{n, plural, =0{no products} =1{# product} other{# products}}', ['n'=>0]);
        $I->waitForText($text);

        $I->amOnPage(Url::to(['/product/product/favorites']));
        $I->waitForText(Yii::t('favorite', 'Favorites'), null, 'h1');
        $I->dontSee($product->title);
    }
    protected function testAddFavorite(AcceptanceTester $I)
    {
        $product = $I->grabFixture('products', 0);

        $I->amOnPage(Url::to($product->url));

        $add = '.addToFavorite';
        $remove = '.removeFromFavorite';
        $I->dontSeeElement($remove);
        $I->seeElement($add);
        $I->click($add);

        $I->waitForElement($remove);
        $I->dontSeeElement($add);

        /*$text = Yii::t('product', 'Comparing products').'('.Html::tag('span',
                Yii::t('order', '{n, plural, =0{no products} =1{# product} other{# products}}', ['n'=>1])
                , ['id'=>'compareCountSpan',]).')';*/
        $text = Yii::t('order', '{n, plural, =0{no products} =1{# product} other{# products}}', ['n'=>1]);
        $I->waitForText($text);

        $I->amOnPage(Url::to(['/product/product/favorites']));
        $I->waitForText($product->title);
    }

}
