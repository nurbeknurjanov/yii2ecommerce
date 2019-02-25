<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace order\models;

use country\models\City;
use country\models\Country;
use country\models\Region;
use coupon\models\Coupon;
use product\models\Product;
use user\models\create\TokenCreate;
use user\models\create\UserCreate;
use user\models\Token;
use Yii;
use user\models\User;
use yii\base\Event;
use yii\base\Exception;
use yii\behaviors\AttributeBehavior;
use yii\db\AfterSaveEvent;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $user_id
 * @property User $user
 * @property string $ip
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property int $city_id
 * @property int $region_id
 * @property int $country_id
 * @property City $city
 * @property Region $region
 * @property Country $country
 * @property string $address
 * @property string $description
 * @property integer $delivery_id
 * @property array $deliveryValues
 * @property string $deliveryText
 * @property string $created_at
 * @property string $updated_at
 * @property double $amount
 * @property integer $payment_type
 * @property array $paymentTypeValues
 * @property string $paymentTypeText
 *
 * @property integer $online_payment_type
 * @property array $onlinePaymentTypeValues
 * @property string $onlinePaymentTypeText
 *
 * @property integer $online_payment_status
 * @property array $onlinePaymentStatusValues
 * @property string $onlinePaymentStatusText
 *
 * @property integer $status
 * @property string $statusText
 * @property array $statusValues
 * @property OrderProduct[] $orderProducts
 * @property integer $coupon_id
 * @property Coupon $coupon
 * @property string $title
 * @property OrderProduct[] $basketProducts
 * @property integer $latestID
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    public function getTitle()
    {
        return Yii::t('order', 'Order').' №:'.$this->id;
    }


    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => date('Y-m-d H:i:s'),
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'user_id',
                ],
                'value' => function ($event) {
                    /* @var $model self */
                    $model = $event->sender;
                    if(Yii::$app->user->identity){
                        $model->name = Yii::$app->user->identity->fullName;
                        $model->email = Yii::$app->user->identity->email;
                        return Yii::$app->user->id;
                    }
                },
            ],
            'ip'=>[
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'ip',
                ],
                'value' => function ($event) {
                    /* @var $model self */
                    $model = $event->sender;
                    return Yii::$app->request->userIP;
                },
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'country_id',
                    self::EVENT_INIT => 'country_id',
                ],
                'value' => function ($event) {
                    /* @var $model self */
                    $model = $event->sender;
                    //$model->country_id=some id;
                    //$model->region_id=some id;
                    if(!$model->country_id && !$model->region_id && $model->city_id){
                        $model->region_id = $model->city->region_id;
                        $model->country_id = $model->city->region->country_id;
                    }
                    return $model->country_id;
                },
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_INIT_BASKET_PRODUCTS => 'basketProducts',
                ],
                'value' => function ($event) {
                    /* @var $model self */
                    $order = $event->sender;
                    $basketProducts = Basket::findAll();
                    $order->amount=0;
                    foreach (Product::find()->defaultFrom()->inBasket()->all() as $product)
                    {
                        $orderProduct = new OrderProduct;
                        $orderProduct->product_id=$product->id;
                        $orderProduct->price=$product->price;
                        $orderProduct->count=$basketProducts[$product->id]['count'];
                        if(isset(Yii::$app->request->post('OrderProduct')[$product->id]))
                            $orderProduct->attributes = Yii::$app->request->post('OrderProduct')[$product->id];
                        $order->amount+=$orderProduct->price* (float) $orderProduct->count;
                        $order->basketProducts[$product->id]=$orderProduct;
                    }
                    return $order->basketProducts;
                },
            ],
        ];
    }
    const EVENT_INIT_BASKET_PRODUCTS='EVENT_INIT_BASKET_PRODUCTS';
    public $basketProducts=[];
    public function loadBasketProducts($data)
    {
        $formName = (new OrderProduct)->formName();
        if(isset($data[$formName])){
            foreach ($data[$formName] as $index=>$basketProductData) {
                $basketProduct = $this->basketProducts[$index];
                $basketProduct->attributes = $basketProductData;
                $this->basketProducts[$index] = $basketProduct;
            }
            return true;
        }
    }
    protected function saveOrderProducts()
    {
        $queryToDelete = OrderProduct::find()->andWhere(['order_id'=> $this->id]);

        foreach ($this->basketProducts as $orderProduct){
            $orderProduct->order_id = $this->id;
            if($orderProduct->save())
                $queryToDelete->andWhere(['!=', 'id', $orderProduct->id]);
            else
                throw new Exception(Html::errorSummary($orderProduct));
        }
        OrderProduct::deleteAll($queryToDelete->where);
        return true;
    }
    public function saveWithOrderProducts()
    {
        if($this->payment_type==$this::PAYMENT_TYPE_ONLINE)
            $this->online_payment_status = $this::ONLINE_PAYMENT_STATUS_PAID;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if($this->save() && $this->saveOrderProducts()){
                $transaction->commit();
                $this->trigger($this::EVENT_AFTER_INSERT_DELAY);
                return true;
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new Exception($e->getMessage());
        }
    }


    public function sendEmailToCustomer()
    {
        return Yii::$app->mailer->compose('order-html', ['model' => $this])
            ->setTo([$this->email => $this->name])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setSubject(Yii::t('order', 'Information about your order'))
            ->send();
    }
    public function sendEmailToSupport()
    {
        return Yii::$app->mailer->compose('order-html', ['model' => $this])
            ->setTo([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setSubject(Yii::t('order', 'Here is new order.'))
            ->send();
    }


    const STATUS_NEW=1;
    const STATUS_PROCESSED=2;
    const STATUS_APPROVED=3;
    public function getStatusValues()
    {
        return [
            self::STATUS_NEW=>Yii::t('order', 'New'),
            self::STATUS_PROCESSED=>Yii::t('order', 'Processed'),
            self::STATUS_APPROVED=>Yii::t('order', 'Approved'),
        ];
    }
    public function getStatusText()
    {
        return isset($this->statusValues[$this->status]) ? $this->statusValues[$this->status]:null;
    }


    public function sendInviteToRegister()
    {
        $token = TokenCreate::createIfNotExists(Token::ACTION_INVITE_FROM_ORDER, null,
            ['email'=>$this->email, 'name'=>$this->name, 'subscribe'=>$this->subscribe]);
        return Yii::$app->mailer->compose('@user/mail/registerAccount-html', ['token' => $token])
            ->setTo([$this->email => $this->name])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setSubject(Yii::t('order', 'Register your account.'))
            ->send();
    }
    public function forceCreateAndBind()
    {
        $user = UserCreate::createUserInactiveForce(['email'=>$this->email, 'name'=>$this->name, 'subscribe'=>$this->subscribe]);
        $user->sendActivateToken();
        $user->tightOrders();
    }


    const USER_ACTION_INVITE='USER_ACTION_INVITE';
    const USER_ACTION_BIND='USER_ACTION_BIND';
    public $userAction=self::USER_ACTION_BIND;
    public $subscribe=true;

    const EVENT_AFTER_INSERT_DELAY = 'EVENT_AFTER_INSERT_DELAY';
    public function init()
    {
        parent::init();

        $this->on(self::EVENT_AFTER_INSERT_DELAY, function(Event $event){
            /* @var $model self */
            $model = $event->sender;

            //update amount of order
            $model->amount = $model->getOrderProducts()->select("SUM(price*count)")
                ->groupBy("order_id")->createCommand()->queryScalar();
            /*if($model->coupon_id)
                $amount= $amount - ($amount/100 * $model->coupon->discount) ;*/
            $model->updateAttributes(['amount'=>$model->amount]);

            //send email to administrator
            $model->sendEmailToSupport();
            //send copy to customer
            if($this->email)
                $model->sendEmailToCustomer();
            //create local order
            OrderLocal::create($model);
            //empty basket
            Basket::deleteAll();

            //send invite
            if(Yii::$app->user->isGuest && $this->email){
                $user = User::findByUsernameOrEmail($this->email);
                if($user){
                    $user->tightOrders();
                    if($user->status!=$user::STATUS_INACTIVE)
                        $user->sendActivateToken();
                }else{
                    if($this->userAction==self::USER_ACTION_INVITE)
                        $this->sendInviteToRegister();
                    if($this->userAction==self::USER_ACTION_BIND)
                        $this->forceCreateAndBind();
                }
            }
        });





    }

    const DELIVERY_PICKUP=1;
    const DELIVERY_SERVICE=2;
    const DELIVERY_COMPANY_DHL=3;
    public function getDeliveryValues()
    {
        return [
            self::DELIVERY_PICKUP=>Yii::t('order', 'Pickup'),
            self::DELIVERY_SERVICE=>Yii::t('order', '{name} Delivery service', ['name'=>Yii::$app->params['name']]),
            self::DELIVERY_COMPANY_DHL=>'DHL',
        ];
    }
    public function getDeliveryText()
    {
        return isset($this->deliveryValues[$this->delivery_id]) ? $this->deliveryValues[$this->delivery_id]:null;
    }

    const PAYMENT_TYPE_CASH=1;
    const PAYMENT_TYPE_ONLINE=2;
    public function getPaymentTypeValues()
    {
        return [
            self::PAYMENT_TYPE_CASH=>Yii::t('order', 'Cash'),
            self::PAYMENT_TYPE_ONLINE=>Yii::t('order', 'Online'),
        ];
    }
    public function getPaymentTypeText()
    {
        return isset($this->paymentTypeValues[$this->payment_type]) ? $this->paymentTypeValues[$this->payment_type]:null;
    }

    const ONLINE_PAYMENT_TYPE_CARD=1;
    const ONLINE_PAYMENT_TYPE_PAYPAL=2;
    public function getOnlinePaymentTypeValues()
    {
        return [
            self::ONLINE_PAYMENT_TYPE_CARD=>Yii::t('order', 'Visa/MasterCard'),
            self::ONLINE_PAYMENT_TYPE_PAYPAL=>Yii::t('order', 'Paypal'),
        ];
    }
    public function getOnlinePaymentTypeText()
    {
        return isset($this->onlinePaymentTypeValues[$this->online_payment_type]) ? $this->onlinePaymentTypeValues[$this->online_payment_type]:null;
    }

    const ONLINE_PAYMENT_STATUS_NOT_PAID=0;
    const ONLINE_PAYMENT_STATUS_PAID=1;
    public function getOnlinePaymentStatusValues()
    {
        return [
            self::ONLINE_PAYMENT_STATUS_NOT_PAID=>Yii::t('order', 'Not paid'),
            self::ONLINE_PAYMENT_STATUS_PAID=>Yii::t('order', 'Paid'),
        ];
    }
    public function getOnlinePaymentStatusText()
    {
        return isset($this->onlinePaymentStatusValues[$this->online_payment_status]) ? $this->onlinePaymentStatusValues[$this->online_payment_status]:null;
    }



    const SCENARIO_GUEST='SCENARIO_GUEST';
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT][] = '!user_id';
        return $scenarios;
    }
    /*
    [default] => Array
    (
        [0] => status
        [1] => delivery_id....
    )
    [SCENARIO_GUEST] => Array
        (
            [0] => email
            [0] => phone
        )
    */
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value'=>self::STATUS_NEW],
            [['user_id', 'delivery_id', 'payment_type', 'online_payment_type', 'online_payment_status'], 'integer'],
            ['description', 'string'],
            ['email', 'email'],
            ['amount', 'number'],
            [['delivery_id', 'amount', 'payment_type'], 'default'],
            [['name', 'email', 'phone', 'address'], 'string', 'max' => 255],
            [['city_id', 'address', 'payment_type', 'delivery_id'], 'required'],
            [['country_id','region_id',], 'safe'],
            ['subscribe', 'boolean'],
            [
                'phone', 'required', 'when'=>function(self $model)
                                        {
                                            return !$model->email;
                                        },
                'whenClient' => "function (attribute, value) {
                                        //alert(attribute.id);
                                        //return !$('#order-email').val();
                                        return !$('[name=\"Order[email]\"]').val();
                                    }",
                'on'=>Order::SCENARIO_GUEST,
            ],
            [
                'email', 'required', 'when'=>function(self $model)
                                        {
                                            return !$model->phone;
                                        },
                'whenClient' => "function (attribute, value) {
                                                        return !$('[name=\"Order[phone]\"]').val();
                                                    }",
                'on'=>Order::SCENARIO_GUEST,
            ],
            ['!user_id', 'safe'],
            ['userAction', 'safe'],
            ['payment_type', 'required'],
            ['online_payment_type', 'required', 'when'=>function(self $model)
                                        {
                                            return $model->payment_type==$model::PAYMENT_TYPE_ONLINE;
                                        },
                'whenClient' => "isPaymentOnline",
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'User'),
            'name' => Yii::t('order', 'Name'),
            'email' => Yii::t('order', 'Email'),
            'phone' => Yii::t('order', 'Phone'),
            'country_id' => Yii::t('order', 'Country'),
            'region_id' => Yii::t('order', 'Region'),
            'city_id' => Yii::t('order', 'City'),
            'address' => Yii::t('order', 'Address'),
            'description' => Yii::t('order', 'Description'),
            'delivery_id' => Yii::t('order', 'Delivery'),
            'created_at' => Yii::t('order', 'Date of order'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'amount' => Yii::t('order', 'Amount'),
            'payment_type' => Yii::t('order', 'Payment type'),
            'status' => Yii::t('product', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::class, ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(Coupon::class, ['id' => 'coupon_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

    /**
     * @inheritdoc
     * @return \order\models\query\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \order\models\query\OrderQuery(get_called_class());
    }


    public function getLatestID()
    {
        $model = Order::find()->orderBy('id DESC')->one();
        if($model)
            return $model->id;
        return 0;
    }
}