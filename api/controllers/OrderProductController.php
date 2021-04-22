<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace api\controllers;


use eav\models\DynamicValue;
use order\models\Basket;
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
use yii\rest\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;


class OrderProductController extends Controller
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors'=>[
                    'Origin' => ['http://m.sakura.com', 'http://demo.sakura.com', 'http://spa.billang.com'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
                ],
            ],
        ];
    }

    /*public function actionGroupProducts($group_id, $self_product_id)
    {
        Yii::$app->response->off('beforeSend');

        $dropdown = (new \order\controllers\OrderProductController('order-product', Yii::$app))
            ->actionGroupProducts($group_id, $self_product_id);

        return $dropdown;
    }*/

    /*public function actionValidate()
    {
        Yii::$app->response->off('beforeSend');

        $model = new OrderProduct;
        $model->load(Yii::$app->request->post());
        return ActiveForm::validate($model);
    }*/
    public function actionValidate()
    {
        $model = new OrderProduct;
        $model->load(Yii::$app->request->post());
        $return=[];
        if($model->validate()){
            //some logic
        }else{
            $return['errors'] = $model->firstErrors;
        }
        return $return;
    }
    /**
     * @return array(type, message, messageBasket, countProduct, errors)
     * */
    public function actionCreate()
    {
        $model = new OrderProduct;

        $errors = [];
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                Basket::create($model);
                Yii::$app->session->setFlash('success', Yii::t('order', 'You added the item into shopping cart.'));
            }else{
                Yii::$app->session->setFlash('error', Html::errorSummary($model));
                $errors = $model->firstErrors;
            }
        }


        $return['errors'] = $errors;
        $return['countProduct'] = isset(Basket::getProduct((int) $model->product_id)['count']) ? Basket::getProduct($model->product_id)['count']:0;
        $return['messageBasket'] = Basket::getNProductsForAmount();
        $return['countBasket'] = Basket::getCount();

        foreach (Yii::$app->session->getAllFlashes() as $type => $message) {
            $return['type']=$type;
            $return['message']=Yii::$app->session->getFlash($type, null, true);
            if($type=='success')
                $return['message'].="<br>".Html::a(Yii::t('order', 'Go to the shopping cart'),
                        ['/order/order/create1']);
            //$session->removeFlash($type);
        }
        return $return;
    }



}