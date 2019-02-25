<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace order\controllers;

use extended\helpers\StringHelper;
use extended\helpers\Helper;
use order\models\Basket;
use order\models\Card;
use order\models\OrderLocal;
use order\models\Paypal;
use PayPal\Api\PaymentExecution;
use PayPal\Common\PayPalModel;
use product\models\Product;
use order\models\OrderProduct;
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
use extended\controller\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
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

/**
 * OrderController implements the CRUD actions for Order model.
 */
class PaypalController extends Controller
{

    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [];
    }



    public function actionButton()
    {
        return $this->render('button');
    }

    public function actionCard()
    {
        $apiContext = Paypal::getApiConnection(false);

        $payment = $this->preparePaymentCard();

        try {
            $return =  $payment->create($apiContext);
            Yii::$app->session->setFlash('success', Yii::t('order', 'Your order is paid by card and accepted.'));
            $model = new Order;
            $model->trigger($model::EVENT_INIT_BASKET_PRODUCTS);
            $model->attributes = Yii::$app->session->get('Order');
            $model->saveWithOrderProducts();
            Yii::$app->session->remove('Order');
            Yii::$app->session->remove('Card');
            return $this->redirect(['/order/order/view', 'id'=>$model->id]);
        }catch (\PayPal\Exception\PayPalConnectionException $ex) {
            Yii::$app->session->setFlash('error', $ex->getData());
            return $this->redirect(['/order/order/create2']);
        }
    }

    protected function preparePaymentCard()
    {
        $cardModel = new Card;
        $cardModel->attributes = Yii::$app->session->get('Card');
        $cardModel->trigger($cardModel::EVENT_BEFORE_VALIDATE);


        $name = explode(' ', $cardModel->name);
        $firstName = $name[0];
        $surName = isset($name[1]) ? $name[1]:$firstName;
        $type = 'visa';
        if($cardModel->number[0]==5)
            $type='mastercard';

        $card = new CreditCard;
        $card->setType($type)
            ->setNumber($cardModel->number)
            ->setExpireMonth($cardModel->expire_date_month)
            ->setExpireYear($cardModel->expire_date_year)
            ->setCvv2($cardModel->ccv)
            ->setFirstName($firstName)
            ->setLastName($surName);

        $fi = new FundingInstrument();
        $fi->setCreditCard($card);


        $payer = new Payer();
        $payer->setPaymentMethod('credit_card');
        $payer->setFundingInstruments([$fi]);

        $payment = new Payment();

        $this->prepareAmount($payer,$payment );

        return $payment;

    }
    protected function prepareAmount(&$payer, &$payment)
    {
        $model = new Order;
        $model->trigger($model::EVENT_INIT_BASKET_PRODUCTS);

        $model->attributes = Yii::$app->session->get('Order');

        $tax = 0;
        $items=[];
        foreach ($model->basketProducts as $basketProduct) {
            $item = new Item;
            $item->setName($basketProduct->product->title)
                ->setCurrency(Yii::$app->formatter->currencyCode)
                ->setDescription(StringHelper::truncate($basketProduct->product->description,20))
                ->setQuantity($basketProduct->count)
                ->setPrice($basketProduct->amount)
                ->setTax($tax);
            $items[]=$item;
        }

        $itemList = new ItemList();
        $itemList->setItems($items);

        $details = new Details;
        $details->setTax($tax);
        $details->setShipping(0);
        $details->setSubtotal($model->amount);

        $amount = new Amount();
        $amount->setTotal($model->amount +$tax);
        $amount->setCurrency(Yii::$app->formatter->currencyCode);
        $amount->setDetails($details);//

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription(StringHelper::truncate($model->description,20))
            ;//->setInvoiceNumber(/*$model->latestID+*/1234);



        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction]);
    }
    protected function preparePaymentPaypal()
    {
        $payer = new Payer;
        $payer->setPaymentMethod('paypal');

        $payment = new Payment();
        $this->prepareAmount($payer, $payment);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(Yii::$app->urlManager->createAbsoluteUrl(['/order/paypal/execute']))
            ->setCancelUrl(Yii::$app->urlManager->createAbsoluteUrl(['/order/order/create2']));

        $payment->setRedirectUrls($redirectUrls);

        return $payment;
    }
    public function actionExecute($paymentId, $token, $PayerID)
    {
        $apiContext = Paypal::getApiConnection(false);

        $payment = Payment::get($paymentId, $apiContext);
        $exec = new PaymentExecution;
        $exec->setPayerId($PayerID);

        try {
            $result = $payment->execute($exec, $apiContext);
            Yii::$app->session->setFlash('success', Yii::t('order', 'Your order is paid by paypal and accepted.'));
            $model = new Order;
            $model->trigger($model::EVENT_INIT_BASKET_PRODUCTS);
            $model->attributes = Yii::$app->session->get('Order');
            $model->saveWithOrderProducts();
            Yii::$app->session->remove('Order');
            Yii::$app->session->remove('Card');
            return $this->redirect(['/order/order/view', 'id'=>$model->id]);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            Yii::$app->session->setFlash('error', $ex->getData());
            return $this->redirect(['/order/order/create2']);
        }
    }
    public function actionPaypal()
    {
        $apiContext=Paypal::getApiConnection(false);

        $payment = $this->preparePaymentPaypal();

        try {
            $payment->create($apiContext);
        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            Yii::$app->session->setFlash('error', $ex->getData());
            return $this->redirect(['/order/order/create2']);
        }


        return $this->redirect($payment->getApprovalLink());

    }
}
