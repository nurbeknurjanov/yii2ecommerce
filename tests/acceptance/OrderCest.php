<?php

use yii\helpers\Url;
use tests\unit\fixtures\ProductFixture;
use tests\unit\fixtures\CategoryFixture;
use order\models\OrderProduct;
use order\models\Order;
use product\models\Product;
use tests\unit\fixtures\OrderFixture;
use tests\unit\fixtures\OrderProductFixture;
use yii\test\ActiveFixture;
use user\models\Token;
use country\models\Country;
use country\models\Region;
use country\models\City;
use user\models\User;
use tests\unit\fixtures\UserFixture;
use tests\unit\fixtures\UserProfileFixture;

class OrderCest
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
            'orders_null' => [
                'class' => OrderFixture::class,
                'dataFile'=>false,
                'depends'=>[],
            ],
            'order_products_null' => [
                'class' => OrderProductFixture::class,
                'dataFile'=>false,
                'depends'=>[],
            ],
            'tokens_null' => [
                'class' => ActiveFixture::class,
                'tableName'=>Token::tableName(),
                'depends'=>[],
            ],
            'users' => [
                'class' => UserFixture::class,
                'depends'=>[],
                'dataFile'=>false,
            ],
            'user_profiles' => [
                'class' => UserProfileFixture::class,
                'depends'=>[],
                'dataFile'=>false,
            ],
        ];
    }

    public function _before(AcceptanceTester $I)
    {
        if(in_array($I->getScenario()->getFeature(),['test order create user','test order create guest tight email'])){
            $I->haveFixtures([
                'users' => [
                    'class' => UserFixture::class,
                    'depends'=>[],
                    'dataFile'=>null,
                ],
                'user_profiles' => [
                    'class' => UserProfileFixture::class,
                    'depends'=>[],
                    'dataFile'=>null,
                ],
            ]);
        }
        $I->clearEmails();
    }


    public function _after(AcceptanceTester $I)
    {
    }

    protected function prepareOrder(AcceptanceTester $I)
    {
        $asus = $I->grabFixture('products', 0);
        $order = new Order;
        $orderProduct = new OrderProduct;
        $basketCest = new \tests\acceptance\BasketCest();
        $result = $basketCest->testBasketStandard($I);

        $I->click("[data-notify='container'] button.close");
        $I->waitForElementNotVisible("[data-notify='container']");


        $I->click($result['basketButton']);


        //$I->click('#basketCountSpan');
        $I->waitForElement(['name'=>$orderProduct->formName()."[$asus->id][count]"]);

        $I->seeInCurrentUrl('/order/order/create1');


        $submit = Yii::t('order', 'Issue the order');

        $I->fillField(['name'=>$orderProduct->formName()."[$asus->id][count]"], 'string value');
        //$I->submitForm('#w1', []);
        $I->click($submit);
        $I->waitForText(Yii::t('yii', '{attribute} must be an integer.',
            ['attribute'=>$orderProduct->getAttributeLabel('count')]), 1);

        $I->fillField(['name'=>$orderProduct->formName()."[$asus->id][count]"], -1);
        //$I->submitForm('#w1', []);
        $I->click($submit);
        $I->waitForText(Yii::t('yii', '{attribute} must be no less than {min}.',
            ['attribute'=>$orderProduct->getAttributeLabel('count'), 'min'=>'1']));

        $I->fillField(['name'=>$orderProduct->formName()."[$asus->id][count]"], 0);
        //$I->submitForm('#w1', []);
        $I->click($submit);
        $I->waitForText(Yii::t('yii', '{attribute} must be no less than {min}.',
            ['attribute'=>$orderProduct->getAttributeLabel('count'), 'min'=>'1']));

        $I->fillField(['name'=>$orderProduct->formName()."[$asus->id][count]"], '');
        //$I->submitForm('#w1', []);
        $I->click($submit);
        $I->waitForText(Yii::t('yii', '{attribute} cannot be blank.',
            ['attribute'=>$orderProduct->getAttributeLabel('count'), 'min'=>'1']));

        $I->fillField(['name'=>$orderProduct->formName()."[$asus->id][count]"], 10000);
        $I->click($submit);
        $I->waitForText(Yii::t('yii', '{attribute} must be no greater than {max}.',
            ['attribute'=>$orderProduct->getAttributeLabel('count'), 'max'=>1000]));

        $I->fillField(['name'=>$orderProduct->formName()."[$asus->id][count]"], 1);
        $I->click($submit);

        $submit = Yii::t('order', 'Make an order');
        $I->waitForText($submit);
        $I->seeInCurrentUrl('/order/order/create2');

        $I->click($submit);
        $I->waitForText(Yii::t('yii', '{attribute} cannot be blank.',
            ['attribute'=>$order->getAttributeLabel('city_id')]));
    }


    protected function createOrder(AcceptanceTester $I, $orderData=[], $logged=false)
    {
        $this->prepareOrder($I);
        $order = new Order;

        $ordersFixture = new OrderFixture([
            'dataFile' => __DIR__.'/../unit/test_fixtures/data/order.php',
            'depends'=>[],
        ]);
        $data = $ordersFixture->getData()[0];
         //\Codeception\Util\Debug::debug($logged);

        foreach ($orderData as $key=>$value)
            $data[$key]=$value;

        $city = City::findOne($data['city_id']);


        if(!$logged){
            if($data['name'])
                $I->fillField($order->formName()."[name]", $data['name']);
            if($data['email'])
                $I->fillField($order->formName()."[email]", $data['email']);
            if($data['phone'])
                $I->fillField($order->formName()."[phone]", $data['phone']);
        }
        if(isset($data['userAction']) && $data['userAction'])
            $I->fillField($order->formName()."[userAction]", $data['userAction']);

        $I->fillField($order->formName()."[address]", $data['address']);

        $I->selectOption($order->formName()."[country_id]", Country::COUNTRY_USA);
        $I->selectOption($order->formName()."[region_id]", Region::REGION_NEW_YORK);
        $I->selectOption($order->formName()."[city_id]", City::CITY_NEW_YORK);

        /*$I->click('.city_id button');
        $I->fillField('.bs-searchbox input', $city->name);
        $I->wait(5);
        $I->selectOption($order->formName()."[city_id]", $data['city_id']);
        $I->wait(3);*/

        /*
        /*$I->selectOption('[type="radio"][name="Order[delivery_id]"]', $data['delivery_id']);
        $I->selectOption('[type="radio"][name="Order[payment_type]"]', $data['payment_type']);
        $I->wait(3);

        /*$I->click('#order-delivery_id label:first-child');
        $I->click('#order-payment_type label:first-child');*/
        $I->selectOption($order->formName()."[delivery_id]", Order::DELIVERY_PICKUP);

        $submit = Yii::t('order', 'Make an order');

        $I->click($submit);
        $I->waitForText(Yii::t('order', 'Your order is accepted.'));

        //$els = $this->getModule('Yii2')->_findElements('.items');
        //$I->amLoggedInAs(1);
    }

    public function testOrderCreateGuestInvite(AcceptanceTester $I)
    {
        $this->createOrder($I,['phone'=>'', 'name'=>'', 'userAction'=>Order::USER_ACTION_INVITE]);

        $order_email = $I->grabFromDatabase(Order::tableName(),'email');


        $this->checkMineOrders($I);
        $this->checkFirst2Emails($I);

        $emails = $I->getEmails();
        $I->assertCount(3, $emails);
        $I->amOnPage('/assets/mails/'.$emails[2]);
        $I->waitForText('Register your account.');
        //$I->seeLink('Register your account.');

        $I->amOnPage(Url::to(['/user/token/run',
            'token' => $I->grabFromDatabase('user_token', 'token')]));
        $I->wait(3);

        $user = $this->checkNewUserCreated($I, $order_email, User::STATUS_ACTIVE);
        $this->checkOrderTightenToUser($I, $user);
        $this->checkMineOrders($I);
    }

    public function testOrderCreateGuestPhone(AcceptanceTester $I)
    {
        $this->createOrder($I, ['email'=>'', 'name'=>'',]);

        $this->checkMineOrders($I);
        $this->checkFirst2Emails($I);
        $I->assertCount(1, $I->getEmails());
        $I->dontSeeInDatabase('user');
    }

    public function testOrderCreateGuestBind(AcceptanceTester $I)
    {
        $this->createOrder($I,['phone'=>'','name'=>'']);

        //$order_email = $I->grabFromDatabase(Order::tableName(),'email');


        /* $user = $this->checkNewUserCreated($I, $order_email, User::STATUS_INACTIVE);
        $this->checkOrderTightenToUser($I, $user);
        $this->checkMineOrders($I);
        $this->checkFirst2Emails($I);

        $emails = $I->getEmails();
        $I->assertCount(3, $emails);
        $I->amOnPage('/assets/mails/'.$emails[2]);
        $I->see('You requested to activate your account.');
        $I->seeLink(Yii::t('common', 'Activate'));

        $I->amOnPage(Url::to(['/user/token/run',
            'token' => $I->grabFromDatabase('user_token', 'token')]));
        $I->wait(1);
        $user = $this->checkNewUserCreated($I, $order_email, User::STATUS_ACTIVE); */
    }
    public function testOrderCreateUser(AcceptanceTester $I, \Helper\Acceptance $helper)
    {
        $user = $I->grabFixture('users', 0);

        //$I->amLoggedInAs(1);
        $helper->login($I);

        $this->createOrder($I,['phone'=>'', 'name'=>''], true);

        $this->checkOrderTightenToUser($I, $user);
        $this->checkMineOrders($I);
        $this->checkFirst2Emails($I);
    }
    public function testOrderCreateGuestTightEmail(AcceptanceTester $I)
    {
        $user = $I->grabFixture('users', 0);
        $this->createOrder($I,['phone'=>'', 'name'=>'', 'email'=>$user->email]);
        $this->checkOrderTightenToUser($I, $user);
    }


    protected function checkOrderTightenToUser(AcceptanceTester $I, User $user)
    {
        $I->seeInDatabase(Order::tableName(), ['user_id'=>$user->id]);
        $order_user_id = $I->grabFromDatabase(Order::tableName(),'user_id', ['user_id'=>$user->id]);
        $I->assertEquals($order_user_id, $user->id);
    }

    protected function checkMineOrders(AcceptanceTester $I)
    {
        $I->click(Yii::t('order', 'My orders'));
        $I->see(Yii::t('order', 'Order').' #1');
    }
    protected function checkFirst2Emails(AcceptanceTester $I)
    {
        $emails = $I->getEmails();
        $I->amOnPage('/assets/mails/'.$emails[0]);
        $I->see('Here is new order.');
        if($email = $I->grabFromDatabase(Order::tableName(),'email')){
            $I->amOnPage('/assets/mails/'.$emails[1]);
            $I->see('Information about your order');
        }
    }
    protected function checkNewUserCreated(AcceptanceTester $I, $email, $status)
    {
        $I->seeInDatabase('user', ['email'=>$email, 'status'=>$status]);
        $user_id = $I->grabFromDatabase('user', 'id',['email'=>$email, 'status'=>$status]);
        return new User(['id'=>$user_id, 'email'=>$email]);
    }


}
