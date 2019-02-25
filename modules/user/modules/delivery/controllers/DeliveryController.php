<?php

namespace delivery\controllers;

use delivery\models\DeliveryForm;
use user\models\User;
use Yii;
use delivery\models\CronEmailMessage;
use delivery\models\search\CronEmailMessageSearch;
use yii\filters\AccessControl;
use extended\controller\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DeliveryController implements the CRUD actions for CronEmailMessage model.
 */
class DeliveryController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index',],
                        'allow' => true,
                        'roles' => [User::ROLE_MANAGER],
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $model = new DeliveryForm();
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->sendMessages();
            //return $this->refresh();
            return $this->render('index', [
                'model' => $model,
            ]);
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }

}
