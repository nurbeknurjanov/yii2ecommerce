<?php
namespace backend\controllers;

use file\models\File;
use user\models\Token;
use Yii;
use extended\controller\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Request;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error', 'alert'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'test'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionTest()
    {
    }
    public function actionIndex()
    {
        return $this->render('index');
    }


}
