<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace api\controllers;


use eav\models\DynamicValue;
use extended\controller\Serializer;
use order\models\Basket;
use order\models\Card;
use product\models\Product;
use order\models\OrderProduct;
use user\models\UserProfile;
use Yii;
use order\models\Order;
use order\models\search\OrderSearch;
use yii\grid\GridView;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use user\models\User;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use order\models\Paypal;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\CreditCard;
use PayPal\Exception\PaypalConnectionException;
use PayPal\Api\Address;
use PayPal\Api\FundingInstrument;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use extended\helpers\StringHelper;
use PayPal\Api\PaymentExecution;


class OrderController extends Controller
{
    public function beforeAction($action)
    {
        Yii::$app->mailer->viewPath = '@order/mail';
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
            'bearerAuth' => [
                'class' => \yii\filters\auth\HttpBearerAuth::class,
            ],
        ];
    }


    public function actionCreate2()
    {
        /*OrderProduct::deleteAll('order_id>3');
        Order::deleteAll('id>3');
        UserProfile::deleteAll('1=1');
        User::deleteAll('id>5');*/


        $model = new Order;
        $model->delivery_id = Order::DELIVERY_COMPANY_DHL;
        $model->payment_type = Order::PAYMENT_TYPE_CASH;
        $model->amount = 0;


        if(Yii::$app->user->isGuest)
            $model->scenario = Order::SCENARIO_GUEST;



        $model->load(Yii::$app->request->post(),'');



        if($model->validate()) {

            $model->trigger(Order::EVENT_INIT_BASKET_PRODUCTS_API);

            $model->saveWithOrderProducts();
        }
        return $model;
    }



    public function actionValidate()
    {
        $model = new Order;
        if (Yii::$app->user->isGuest)
            $model->scenario = Order::SCENARIO_GUEST;
        $card = new Card;

        $model->load(Yii::$app->request->post());
        $card->load(Yii::$app->request->post());

        $return = [];
        /*$errorArray = ActiveForm::validate($model);
        if($model->payment_type==$model::PAYMENT_TYPE_ONLINE && $model->online_payment_type==$model::ONLINE_PAYMENT_TYPE_CARD)
            $errorArray = array_merge($errorArray, ActiveForm::validate($card));

        return $errorArray;*/

        $orderValidate = $model->validate();
        $cardValidate = true;
        if ($model->payment_type == $model::PAYMENT_TYPE_ONLINE && $model->online_payment_type == $model::ONLINE_PAYMENT_TYPE_CARD)
            $cardValidate = $card->validate();
        if ($orderValidate && $cardValidate) {

            //return Yii::$app->getResponse()->redirect(Url::to(['order/test2']), 301, false);

            return [
                'order' => (new Serializer)->serialize($model),
                'card' => (new Serializer)->serialize($card),
            ];
        } else {
            $return['errors'] = array_merge($model->firstErrors, $card->firstErrors);
        }
        return $return;

    }


}