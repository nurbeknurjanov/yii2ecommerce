<?php

namespace api\controllers;

use user\models\create\TokenCreate;
use user\models\User;
use user\models\Token;
use user\models\LoginForm;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class LoginController extends \yii\rest\Controller
{
    public function behaviors()
    {
        return [
            'compositeAuth'=>[
                'class' => CompositeAuth::className(),
                'except' => ['index'],
                'authMethods' => [
                    HttpBearerAuth::className(), //header Authorization=Bearer token
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only'=>['login'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->post(), '');
        if($model->validate()){
            $user = $model->getUser();
            $token = TokenCreate::createNewRefresh(Token::ACTION_LOGIN, $user);
            $user->_fields['token']=function() use ($token){
                return $token->token;
            };
            return $user;
        }
        return $model;
    }

} 