<?php

namespace tests\unit;

use tests\unit\fixtures\OrderProductFixture;
use user\models\Token;
use user\models\User;
use yii\helpers\Html;
use eav\models\DynamicField;
use tests\unit\fixtures\CategoryFixture;
use extended\helpers\Helper;
use tests\unit\fixtures\UserFixture;
use tests\unit\fixtures\UserProfileFixture;
use product\models\Product;
use tests\unit\fixtures\DynamicFieldFixture;
use tests\unit\fixtures\DynamicValueFixture;
use eav\models\DynamicValue;
use product\models\search\ProductSearchFrontend;
use tests\unit\fixtures\ProductFixture;
use order\models\Basket;
use order\models\OrderProduct;
use order\models\Order;
use tests\unit\fixtures\OrderFixture;
use order\models\OrderLocal;
use yii\web\Request;
use yii\test\ActiveFixture;
use Yii;

class OrderTest extends \Codeception\Test\Unit
{
    //use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;


    public function _fixtures()
    {
        $fixtures = [
            'products' => [
                'class' => ProductFixture::class,
                'dataFile' => __DIR__.'/test_fixtures/data/product.php',
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
            ],
            'user_profiles' => [
                'class' => UserProfileFixture::class,
                'depends'=>[],
                'dataFile'=>false,
            ],
        ];

        if(in_array($this->getName(),['testOrderCreateUser', 'testOrderCreateGuestTightEmail'])){
             $fixtures['users']=[
                 'class' => UserFixture::class,
                 'dataFile'=>null,
                 'depends'=>[],
             ];
             $fixtures['users_profile']=[
                 'class' => UserProfileFixture::class,
                 'dataFile'=>null,
                 'depends'=>[],
             ];
        }

        return $fixtures;
    }

    public function testOrderCreateUser()
    {
        $user = User::find()->one();
        Yii::$app->user->setIdentity($user);
        $this->tester->assertFalse(Yii::$app->user->isGuest);

        $model = $this->createOrder();
        $emails = $this->tester->grabSentEmails();
        $this->tester->assertCount(2, $emails);

        $this->checkOrderTightedToUser($model, Yii::$app->user->identity);
        $this->checkMineOrders();
        $this->checkFirst2Emails($model);
    }
    public function testOrderCreateGuestTightEmail()
    {
        $user = $this->tester->grabFixture('users', 0);
        /*$model = $this->createOrder(['email'=>$user->email]);
        $this->checkOrderTightedToUser($model, $user);*/
    }
    protected function _before()
    {
        Yii::$app->mailer->viewPath = '@order/mail';
        $this->tester->mockRequest();
    }


    protected function createOrder($orderData=[])
    {
        $product = $this->tester->grabFixture('products', 0);
        $ordersFixture = new OrderFixture([
            'dataFile' => __DIR__.'/test_fixtures/data/order.php',
            'depends'=>[],
        ]);
        $data = $ordersFixture->getData()[0];
        unset($data['id'],$data['user_id'],
            $data['created_at'],$data['updated_at'],
            $data['status'],$data['amount']);

        Basket::create(new OrderProduct([
            'product_id'=>$product->id,
            'price'=>$product->price,
            'count'=>1,
        ]));

        $model = new Order($orderData);
        if(Yii::$app->user->isGuest)
            $model->scenario = Order::SCENARIO_GUEST;
        $model->trigger($model::EVENT_INIT_BASKET_PRODUCTS);
        $model->load($data, '');
        $model->attributes = $orderData;
        //$model->ip = $data['ip'];
        //$model->detachBehavior('ip');
        $basketData = array(
            (new OrderProduct)->formName()=>array(
                $product->id=>[
                    'product_id'=>$product->id,
                    'price'=>$product->price,
                    'count'=>1,
                ]
            )
        );
        $model->loadBasketProducts($basketData);
        $this->tester->assertTrue($model->saveWithOrderProducts());
        $this->tester->seeRecord(Order::class);
        $this->tester->seeRecord(OrderProduct::class);
        return $model;
    }

    protected function checkNewUserCreated($email)
    {
        $user = User::findOne(['email'=>$email]);
        $this->tester->assertNotEmpty($user);
        return $user;
    }
    protected function checkOrderTightedToUser(Order $order, User $user)
    {
        $this->tester->seeRecord(Order::class, ['user_id'=>$user->id]);
        $order->refresh();
        $this->tester->assertEquals($order->user_id, $user->id);
    }
    protected function checkMineOrders()
    {
        $this->tester->assertCount(1, OrderLocal::findAll());
        $this->tester->assertEquals(1, Order::find()->mine()->count());
    }
    protected function checkFirst2Emails($model)
    {
        $emails = $this->tester->grabSentEmails();
        /* @var $emails \yii\swiftmailer\Message[] */
        $this->tester->assertEquals($emails[0]->getSubject(), 'Here is new order.');
        if($model->email)
            $this->tester->assertEquals($emails[1]->getSubject(), 'Information about your order');
    }

    public function testOrderCreateGuestInvite()
    {
        $this->tester->assertTrue(Yii::$app->user->isGuest);
        $model = $this->createOrder(['userAction'=>Order::USER_ACTION_INVITE]);

        $this->checkMineOrders();
        $this->checkFirst2Emails($model);

        $emails = $this->tester->grabSentEmails();
        $this->tester->assertCount(3, $emails);
        /* @var $emails \yii\swiftmailer\Message[] */
        $this->tester->assertEquals($emails[2]->getSubject(), 'Register your account.');


        $this->tester->seeRecord(Token::class);
        $token = $this->tester->grabRecord(Token::class);
        $token->run();

        $user = $this->checkNewUserCreated($model->email);
        $this->tester->assertEquals($user->status, User::STATUS_ACTIVE);
        $this->checkOrderTightedToUser($model, $user);
        $this->checkMineOrders();
    }
    public function testOrderCreateGuestBind()
    {
        $this->tester->assertTrue(Yii::$app->user->isGuest);
        $model = $this->createOrder(['userAction'=>Order::USER_ACTION_BIND]);

        $user = $this->checkNewUserCreated($model->email);
        $this->checkOrderTightedToUser($model, $user);
        $this->checkMineOrders();
        $this->checkFirst2Emails($model);

        $emails = $this->tester->grabSentEmails();
        $this->tester->assertCount(3, $emails);
        /* @var $emails \yii\swiftmailer\Message[] */
        $this->tester->assertEquals($emails[2]->getSubject(), 'You requested to activate your account.');

        foreach ($emails as $n=>$email){
            //if($email->getSubject()=='')
            //echo $email->getSubject().$n."----\n";
            //echo $email->toString()."----\n";
            //$body = $email->getSwiftMessage()->toString();
            //echo $email->getSwiftMessage()->getBody()."----\n";
        }

        $this->tester->seeRecord(Token::class);
        $token = $this->tester->grabRecord(Token::class);
        $token->run();
        $user->refresh();
        $this->tester->assertEquals($user->status, User::STATUS_ACTIVE);

    }

    public function testOrderCreateGuestPhone()
    {
        $this->tester->assertTrue(Yii::$app->user->isGuest);
        $model = $this->createOrder(['email'=>'', 'phone'=>'996558011477']);

        /*$this->checkMineOrders();
        $this->checkFirst2Emails($model);
        $this->tester->assertCount(1, $this->tester->grabSentEmails());

        $this->tester->cantSeeRecord(User::class);*/
    }





}