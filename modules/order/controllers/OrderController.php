<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace order\controllers;

use http\Url;
use order\models\Basket;
use order\models\Card;
use order\models\OrderLocal;
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


/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['create', 'create1', 'create2', 'create3'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('updateOrder', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('deleteOrder', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('indexOrder');
                        }
                    ],
                    [
                        'actions' => ['list'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('viewOrder', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('backend/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->mine();

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if(Yii::$app->id=='app-backend')
            return $this->render('backend/view', [
                'model' => $model
            ]);
        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */


    //update basket
    public function actionCreate1()
    {
        if(Basket::isEmpty())
            Yii::$app->session->setFlash('warning', Yii::t('order', 'Your shopping cart is empty.'));

        $model = new Order;
        if(Yii::$app->user->isGuest)
            $model->scenario = Order::SCENARIO_GUEST;
        $model->trigger($model::EVENT_INIT_BASKET_PRODUCTS);

        if($model->loadBasketProducts(Yii::$app->request->post())){
            $errorArray = ActiveForm::validateMultiple($model->basketProducts);
            //$errorArray['product-price'][]='some error';
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $errorArray;
            }
            foreach ($model->basketProducts as $orderProduct)
                if($orderProduct->validate())
                    Basket::update($orderProduct);
            if(!$errorArray)
                return $this->redirect(['create2']);
        }

        return $this->render('create1', [
            'model' => $model,
        ]);
    }

    //do order
    public function actionCreate2()
    {
        $model = new Order;
        $card = new Card;
        if(Yii::$app->session->get('Order'))
            $model->attributes = Yii::$app->session->get('Order');
        if(Yii::$app->session->get('Card'))
            $card->attributes = Yii::$app->session->get('Card');

        if(Yii::$app->user->isGuest)
            $model->scenario = Order::SCENARIO_GUEST;

        if(Basket::isEmpty()){
            Yii::$app->session->setFlash('warning', Yii::t('order', 'Your shopping cart is empty.'));
            return $this->goAlert();
        }


        $model->trigger($model::EVENT_INIT_BASKET_PRODUCTS);

        if($model->load(Yii::$app->request->post()) && $model->loadBasketProducts(Yii::$app->request->post())) {
            $card->load(Yii::$app->request->post());

            if(Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $errorArray = array_merge(ActiveForm::validate($model), ActiveForm::validateMultiple($model->basketProducts));

                if($model->payment_type==$model::PAYMENT_TYPE_ONLINE && $model->online_payment_type==$model::ONLINE_PAYMENT_TYPE_CARD)
                    $errorArray = array_merge($errorArray, ActiveForm::validate($card));
                //$errorArray['product-price'][]='some error';
                return $errorArray;
            }
            try{
                if($model->payment_type==$model::PAYMENT_TYPE_ONLINE){
                    Yii::$app->session->remove('Order');
                    Yii::$app->session->set('Order', $model->attributes);
                    if($model->online_payment_type==$model::ONLINE_PAYMENT_TYPE_PAYPAL)
                        return $this->redirect(['/order/paypal/paypal']);
                    if($model->online_payment_type==$model::ONLINE_PAYMENT_TYPE_CARD){
                        Yii::$app->session->remove('Card');
                        Yii::$app->session->set('Card', $card->attributes);
                        return $this->redirect(['/order/paypal/card']);
                    }
                }else{
                    if($model->saveWithOrderProducts()){
                        Yii::$app->session->setFlash('success', Yii::t('order', 'Your order is accepted.'));
                        return $this->redirect(['view', 'id'=>$model->id,]);
                    }
                }
            }catch(Exception $e){
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

        }

        return $this->render('create2', [
            'model' => $model,
            'card' => $card,
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('backend/update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }


    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
