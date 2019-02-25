<?php

namespace api\controllers;


use frontend\models\ContactForm;
use user\models\User;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;



class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
            'compositeAuth'=>[
                'class' => CompositeAuth::className(),
                'except' => ['options', 'index'],
                //'optional'=>['create', 'update', 'delete', 'view', 'index'],
                'authMethods' => [
                    HttpBearerAuth::className(), //header Authorization=Bearer token,
                    QueryParamAuth::className(), //GET access-token=token,
                    [
                        'class'=>HttpBasicAuth::className(), //header Authorization=Basic btoa("username:password") or btoa("{token}:")
                        'auth'=> function ($username, $password){
                                if($password){
                                    $user = User::findByUsernameOrEmail($username);
                                    if($user && $user->validatePassword($password))
                                        return $user;
                                }
                                else
                                    return User::findIdentityByAccessToken($username);
                            },
                    ],
                ],
            ],
            //'rateLimiter' => [  'class' => \yii\filters\RateLimiter::className() ],
            'access' => [
                'class' => AccessControl::className(),
                'only'=>[/*'index',*/ 'some'],
                //'except' => ['view'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                    ],
                ],
                'denyCallback'=>function(){  },
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->renderPartial('@themes/sakura/site/index');
    }

    public function actionContact()
    {
        $model = new ContactForm;

        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                if ($model->sendEmail())
                    Yii::$app->session->setFlash('success', Yii::t('common', 'Thank you for contacting us. We will respond to you as soon as possible.'));
                else
                    Yii::$app->session->setFlash('error', 'There was an error sending email.');

            }else{
                return [
                    'errors'=>$model->getFirstErrors()
                ];
            }
        }

    }
} 