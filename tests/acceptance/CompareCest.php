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

class CompareCest
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


    public function testRemoveCompare(AcceptanceTester $I)
    {
        $this->testAddCompare($I);
        $product = $I->grabFixture('products', 0);

        $I->goToProduct($I, $product);



        $add = '.addToCompare';
        $remove = '.removeFromCompare';
        $I->waitForElement($remove);
        $I->seeElement($remove);
        $I->dontSeeElement($add);
        $I->click($remove);
        $I->waitForElement($add);
        $I->dontSeeElement($remove);


        $text = Yii::t('order', '{n, plural, =0{no products} =1{# product} other{# products}}', ['n'=>0]);
        $I->waitForText($text);

        $I->amOnPage(Url::to(['/product/compare/index']));
        $I->waitForText(Yii::t('order', 'Comparing products'), null, 'h1');
        $I->dontSee($product->title);
    }
    public function testRemoveCompareFromCompare(AcceptanceTester $I)
    {
        $this->testAddCompare($I);

        $remove = Yii::t('common', 'Remove');
        $I->seeLink($remove);
        $I->click($remove);

        $I->performOn('.bootbox',
            \Codeception\Util\ActionSequence::build()
                ->waitForText(Yii::t('product', 'Do you want to remove the item from compare ?'))
                ->click(Yii::t('common', 'CONFIRM'))
        );
        /*$I->waitForElementVisible('.bootbox');
        $I->waitForText(Yii::t('product', 'Do you want to remove the item from compare ?'));
        $I->click(Yii::t('common', 'CONFIRM'));
        $I->waitForElementNotVisible('.bootbox');*/


        $I->waitForText(Yii::t('product', 'You didn\'t select the items to compare.'));

    }
    protected function testAddCompare(AcceptanceTester $I)
    {
        $product = $I->grabFixture('products', 0);

        $I->goToProduct($I, $product);



        $add = '.addToCompare';
        $remove = '.removeFromCompare';
        $I->dontSeeElement($remove);
        $I->seeElement($add);
        $I->click($add);
        $I->waitForElement($remove);
        $I->dontSeeElement($add);

        $text = Yii::t('order', '{n, plural, =0{no products} =1{# product} other{# products}}', ['n'=>1]);
        $I->waitForText($text);

        $I->amOnPage(Url::to(['/product/compare/index']));
        $I->waitForText($product->title);
    }

}
