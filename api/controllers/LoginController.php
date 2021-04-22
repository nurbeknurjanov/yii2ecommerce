<?php

namespace api\controllers;

use user\models\create\TokenCreate;
use user\models\create\UserCreate;
use user\models\PasswordResetRequestForm;
use user\models\ResetPasswordForm;
use user\models\User;
use user\models\Token;
use user\models\LoginForm;
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class LoginController extends \yii\rest\Controller
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
            'compositeAuth'=>[
                'class' => CompositeAuth::class,
                'except' => ['index','auth-by-network', 'send-link-to-restore-password', 'reset-password'],
                'authMethods' => [
                    HttpBearerAuth::class,
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'auth-by-network', 'send-link-to-restore-password', 'reset-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['post'],
                    'auth-by-network' => ['post'],
                    'send-link-to-restore-password' => ['post'],
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
        return $model;//нужно валидировать и отправлять саму же форму
    }

    public function actionAuthByNetwork()
    {
        $attributes = Yii::$app->request->bodyParams;

        if(!isset($attributes['email']) || !$attributes['email'])
            throw new Exception("Email is missing");

        if(!(   $user=User::findOne(['email'=>$attributes['email']])   )){
            $user = UserCreate::createUserInactiveForce([
                'email'=>$attributes['email'],
                'name'=>$attributes['name'],
            ]);
            $user->activateStatus();
        }

        if(!$user->id)
            throw new Exception(strip_tags(Html::errorSummary($user, ['header'=>false,])));


        $token = TokenCreate::createNewRefresh(Token::ACTION_LOGIN, $user);
        $user->_fields['token']=function() use ($token){
            return $token->token;
        };
        return $user;
    }


    public function actionSendLinkToRestorePassword()
    {
        $model = new PasswordResetRequestForm();
        $model->load(Yii::$app->request->post(), '');

        $model->off(ActiveRecord::EVENT_BEFORE_VALIDATE);
        if ($model->validate()) {
            Yii::$app->mailer->viewPath = '@user/mail';
            $model->sendEmail();
        }
        return $model;
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if($model->load(Yii::$app->request->post(), '')){
            $model->off(ActiveRecord::EVENT_BEFORE_VALIDATE);
            if ($model->validate()) {
                $model->resetPassword();
            }
        }

        return $model;
    }

} 