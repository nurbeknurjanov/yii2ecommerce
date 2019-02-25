<?php


namespace favorite\controllers;

use favorite\models\Favorite;
use favorite\models\FavoriteLocal;
use product\models\Product;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use user\models\User;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\web\Response;

class FavoriteController extends \extended\controller\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => [User::ROLE_GUEST],
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['model_id']))
                                throw new Exception("model_id parameter is missing");
                            if(!isset($_GET['model_name']))
                                throw new Exception("model_name parameter is missing");
                            return Yii::$app->user->can('createFavorite', ['object'=>$_GET['model_name']::findOne($_GET['model_id'])]);
                        }
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [User::ROLE_GUEST],
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['model_id']))
                                throw new Exception("model_id parameter is missing");
                            if(!isset($_GET['model_name']))
                                throw new Exception("model_name parameter is missing");
                            return Yii::$app->user->can('deleteFavorite', ['object'=>$_GET['model_name']::findOne($_GET['model_id'])]);
                        }
                    ],
                ],
            ],
        ];
    }


    public function actionCreate($model_name, $model_id)
    {
        $model = new Favorite;
        $model->trigger($model::EVENT_INIT);
        $model->model_name = $model_name;
        $model->model_id = $model_id;

        //$this->performAjaxValidation($model);

        //$model->load($_POST);

        /*
        $request = new Request();
        $request->baseUrl = Yii::$app->request->baseUrl;
        $request->url = Yii::$app->getUser()->getReturnUrl(null);
        $route = Yii::$app->urlManager->parseRequest($request)[0];
        $route = str_replace(Yii::$app->language.'/', '', $route);
        if($route==Yii::$app->language)
            $route='';
        if(isset($parse['query']))
            parse_str($parse['query'], $params);
        else
            $params=[];

        if(isset($_POST['scroll']))
            $params['scroll'] = $_POST['scroll'];
        if(isset($_GET['scroll']))
            $params['scroll'] = $_GET['scroll'];
        return Yii::$app->response->redirect(Url::to([0=>'/'.$route] + $params));
        */


        if($model->validate()){
            FavoriteLocal::create($model);
            Yii::$app->session->setFlash('success', Yii::t('favorite', 'You successfully added the item into favorites.'));
        }else {
            Yii::$app->session->setFlash('error', Html::errorSummary($model));
        }

        if(Yii::$app->request->headers->get('returnOnlyAlert')){
            $return = [];
            $return['count'] = FavoriteLocal::getCount();
            $return['favoriteMessage'] = FavoriteLocal::getNProducts();
            Yii::$app->response->format = Response::FORMAT_JSON;
            foreach (Yii::$app->session->getAllFlashes() as $type => $message) {
                $return['type']=$type;
                $return['message']=Yii::$app->session->getFlash($type, null, true);
                //$session->removeFlash($type);
            }
            return $return;
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionDelete($model_name, $model_id)
    {
        try {
            FavoriteLocal::delete($model_name, $model_id);
            Yii::$app->session->setFlash('success', Yii::t('favorite', 'You successfully removed the item from favorites.'));
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        if(Yii::$app->request->headers->get('returnOnlyAlert')){
            $return = [];
            $return['count'] = FavoriteLocal::getCount();
            $return['favoriteMessage'] = FavoriteLocal::getNProducts();
            Yii::$app->response->format = Response::FORMAT_JSON;
            foreach (Yii::$app->session->getAllFlashes() as $type => $message) {
                $return['type']=$type;
                $return['message']=Yii::$app->session->getFlash($type, null, true);
                //$session->removeFlash($type);
            }
            return $return;
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

}