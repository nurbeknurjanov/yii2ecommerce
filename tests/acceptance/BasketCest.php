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

class BasketCest
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


    public function testBasketStandard(AcceptanceTester $I)
    {
        $asus = $I->grabFixture('products', 0);
        $I->amOnPage(Url::to(Yii::$app->homeUrl));

        $I->showBasket($I,$asus);


        $I->click(Yii::t('order', 'Continue shopping'));
        $I->waitForElementNotVisible('#basketModal');
        $I->waitForElement("[data-notify='container']");
        $I->waitForText(Yii::t('order', 'You added the item into shopping cart.'));


        $basketButton = Yii::t('order', "{nProducts} for {amount}",
            [
                'amount'=>Yii::$app->formatter->asCurrency(1*$asus->price),
                'nProducts'=>Yii::t('order', '{n, plural, =0{no products} =1{# product} other{# products}}', ['n'=>1]),
                ]) ;

        $I->waitForText($basketButton);
        //$I->waitForElement(['css'=>'.basketActive']);
        $I->waitForElement('.basketActive');


        return [
            'basketButton'=>$basketButton,
        ];
    }

    public function testBasketQuick(AcceptanceTester $I)
    {
        $asus = $I->grabFixture('products', 0);
        $I->amOnPage(Url::to(Yii::$app->homeUrl));

        $I->showBasket($I,$asus);

        $I->click(Yii::t('order', 'Issue the order'));
        $I->waitForText(Yii::t('order', 'Issue the order'), null, 'h1');
        $I->seeInCurrentUrl('/order/order/create2');
    }
    public function testBasketGrouped(AcceptanceTester $I)
    {
        $orderProduct = new OrderProduct;
        $fanta = $I->grabFixture('products', 2);
        $fantaBig = $I->grabFixture('products', 3);

        $I->goToCategory($I,$I->grabFixture('categories', 0));

        $I->cantSeeElement('#showBasket-'.$fantaBig->id);

        $I->showBasket($I,$fanta, false);

        $I->selectOption($orderProduct->formName().'[product_id]', $fantaBig->id);
        $I->waitForText((string) $fantaBig->price);
        $I->seeInField($orderProduct->formName().'[price]', $fantaBig->price);

        $I->seeInField($orderProduct->formName().'[count]', 1);
        //$I->cantSeeInField('user[name]', 'Miles');
        //$I->grabValueFrom('input[name=api]');
        $I->click(Yii::t('order', 'Continue shopping'));
        $I->waitForElementNotVisible('#basketModal');
        $I->waitForText(Yii::t('order', 'You added the item into shopping cart.'));
    }
}
