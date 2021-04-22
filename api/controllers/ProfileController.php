<?php

namespace api\controllers;

use file\models\File;
use user\models\create\UserCreate;
use user\models\PasswordResetRequestForm;
use user\models\User;
use user\models\Token;
use user\models\LoginForm;
use Yii;
use yii\base\Exception;
use yii\bootstrap\ActiveForm;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ProfileController extends \yii\rest\Controller
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
            'bearerAuth' => [
                'class' => \yii\filters\auth\HttpBearerAuth::class,
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['view', 'update', 'logout', 'change-password', 'set-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }



    public function actionView()
    {
        $user = Yii::$app->user->identity;
        return ['user'=>$user];
    }

    public function actionLogout()
    {
        $user = Yii::$app->user->identity;

        return ['user'=>$user];
    }


    public function actionUpdate()
    {
        $model = Yii::$app->user->identity;
        $model->scenario = User::SCENARIO_EDIT_PROFILE;
        $profile = $model->userProfileObject;
        $profile->userObject = $model;

        if (Yii::$app->request->isPost){

            $model->load(Yii::$app->request->post(), '');
            $profile->load(Yii::$app->request->post('userProfile'), '');

            $model->imageAttribute = UploadedFile::getInstanceByName('imageAttribute');
            $model->imagesAttribute = UploadedFile::getInstancesByName('imagesAttribute');


            $model->off(ActiveRecord::EVENT_BEFORE_VALIDATE);

            if ($model->validate() && $profile->validate()){


                $transaction = Yii::$app->db->beginTransaction();

                if(!$model->save())
                    throw new Exception(Html::errorSummary($model, ['header'=>false]));
                if(!$profile->save())
                    throw new Exception(Html::errorSummary($profile, ['header'=>false]));

                $transaction->commit();

                $model->refresh();
                $profile->refresh();
            }

        }

        return $model;
    }


    public function actionChangePassword()
    {
        $model = Yii::$app->user->identity;
        $model->scenario = 'changePassword';

        $model->load(Yii::$app->request->post(), '');

        $model->off(ActiveRecord::EVENT_BEFORE_VALIDATE);

        if ($model->validate(['password', 'password_new', 'password_new_repeat'])){
            $model->setPassword($model->password_new);
            $model->save(false);
            $model->refresh();
        }
        return $model;
    }

    public function actionSetPassword()
    {
        $model = Yii::$app->user->identity;
        $model->scenario='setPassword';

        $model->load(Yii::$app->request->post(), '');

        $model->off(ActiveRecord::EVENT_BEFORE_VALIDATE);

        if ($model->validate(['password_set', 'password_set_repeat'])){
            $model->setPassword($model->password_set);
            $model->save(false);
            $model->refresh();
        }
        return $model;
    }




} 