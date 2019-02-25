<?php

namespace api\controllers;

use user\models\User;
use user\models\Token;
use user\models\LoginForm;
use Yii;
use yii\base\Exception;
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
            'compositeAuth'=>[
                'class' => CompositeAuth::className(),
                'authMethods' => [
                    HttpBearerAuth::className(), //header Authorization=Bearer token
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only'=>['view', 'update'],
                'rules' => [
                    [
                        'actions' => ['view', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'update' => ['post'],
                ],
            ],
        ];
    }

    public function actionView()
    {
        return Yii::$app->user->identity;
    }

    public function actionUpdate()
    {
        $model = Yii::$app->user->identity;

        $model->load(Yii::$app->request->post(), '');
        if (Yii::$app->request->isPost){
            $model->imageAttribute = UploadedFile::getInstanceByName('imageAttribute');
            $model->imagesAttribute = UploadedFile::getInstancesByName('imagesAttribute');
        }

        $model->off(ActiveRecord::EVENT_BEFORE_VALIDATE);

        if ($model->validate()){
            $model->save();
            $model->refresh();
        }
        return $model;
    }

} 