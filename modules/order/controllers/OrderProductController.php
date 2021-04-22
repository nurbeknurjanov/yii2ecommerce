<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace order\controllers;


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
use extended\controller\Controller;
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
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'delete', 'delete-all', 'create-quick','group-products'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    public function actionGroupProducts($group_id, $self_product_id)
    {
        $groupProducts = Product::find()->andWhere(['group_id'=>$group_id])->orderBy('id')->all();
        $orderProduct = new OrderProduct;
        foreach ($groupProducts as $groupProduct)//making selected
            if(Basket::isAlreadyInBasket($groupProduct->id)){
                $orderProduct->product_id = $groupProduct->id;
                if($groupProduct->id==$self_product_id)//self is priority
                    break;
            }


        if(!$orderProduct->product_id)
            $orderProduct->product_id = $groupProducts[0]->id;


        $dropdown =  Html::activeDropDownList($orderProduct, 'product_id',
            ArrayHelper::map($groupProducts, 'id','title'),
            ['class'=>'form-control', 'prompt'=>'Select']);

        foreach ($groupProducts as $model){
            $count = Basket::getProduct($model->id) ? Basket::getProduct($model->id)['count']:1;
            $dropdown = str_replace("value=\"{$model->id}\"",
                "value=\"{$model->id}\" 
                data-price=\"{$model->price}\"
                data-count=\"{$count}\"
                ", $dropdown);
        }



        return $dropdown;
    }


    public function actionCreate()
    {
        $model = new OrderProduct;

        if(!Yii::$app->request->headers->get('returnOnlyAlert'))
            $this->performAjaxValidation($model);

        $model->load($_POST);

        if($model->validate()){
            Basket::create($model);
            Yii::$app->session->setFlash('success', Yii::t('order', 'You added the item into shopping cart.'));
        }else
            Yii::$app->session->setFlash('error', Html::errorSummary($model));


        if(Yii::$app->request->isAjax && Yii::$app->request->headers->get('returnOnlyAlert')){

            if(Yii::$app->request->post('buttonValue')=='order')
                return $this->redirect(['/order/order/create2']);

            $return['countProduct'] = Basket::getProduct($model->product_id)['count'];
            $return['messageBasket'] = Basket::getNProductsForAmount();

            Yii::$app->response->format = Response::FORMAT_JSON;
            foreach (Yii::$app->session->getAllFlashes() as $type => $message) {
                $return['type']=$type;
                $return['message']=Yii::$app->session->getFlash($type, null, true);
                if($type=='success')
                    $return['message'].="<br>".Html::a(Yii::t('order', 'Go to the shopping cart'), ['/order/order/create1']);
                //$session->removeFlash($type);
            }
            return $return;
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionDelete($product_id)
    {
        try {
            Basket::delete($product_id);
            Yii::$app->session->setFlash('success', Yii::t('order', 'You removed the item from shopping cart.'));
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionDeleteAll()
    {
        try {
            Basket::deleteAll();
            Yii::$app->session->setFlash('success', Yii::t('order', 'You removed all item from shopping cart.'));
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}