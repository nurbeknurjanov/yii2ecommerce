<?php

namespace api\modules\v2\controllers;


use user\models\User;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;


use modules\xxxanatomy\models\Phase;
use modules\xxxanatomy\models\search\PhaseSearch;


class PhaseController extends ActiveController
{
    public function behaviors()
    {
        return [
            'compositeAuth'=>[
                'class' => CompositeAuth::className(),
                'except' => ['view', 'index'],
                'authMethods' => [
                    HttpBearerAuth::className(), //header Authorization=Bearer token
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only'=>['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['view', 'index'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles'=>['@'],
                        'matchCallback' => function($rule, $action){
                                return Yii::$app->isSourceLanguage /*&& Yii::$app->user->can('createPhase')*/;
                            }
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles'=>['@'],
                        /*'matchCallback' => function($rule, $action){
                                if(!isset($_GET['id']))
                                    throw new Exception("id parameter is missing", 400);
                                return Yii::$app->user->can('updatePhase', ['model' => $this->findModel($_GET['id'])]);
                            }*/
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles'=>['@'],
                        /*'matchCallback' => function($rule, $action){
                                if(!isset($_GET['id']))
                                    throw new Exception("id parameter is missing", 400);
                                return Yii::$app->user->can('deletePhase', ['model' => $this->findModel($_GET['id'])]);
                            }*/
                    ],
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
        ];
    }

    public $modelClass = 'modules\xxxanatomy\models\Phase';

    /**
     * Finds the Phase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Phase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Phase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index'] = [
            'class' => 'yii\rest\IndexAction',
            'modelClass' => $this->modelClass,
            'prepareDataProvider' =>  function ($action) {
                    $searchModel = new PhaseSearch();
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                    //$dataProvider->query->andFilterWhere(['id'=>'some_id',]);
                    return $dataProvider;
                }
        ];

        //unset($actions['create']);
        //unset($actions['update']);
        //unset($actions['delete']);
        //unset($actions['index']);



        return $actions;
    }

    /*public function actionCreate()
    {
        $model = new Phase();
        $model->load(Yii::$app->request->post(), '');
        $model->save();
        return $model;
    }*/

    /*public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post(), '');
        $model->save();
        return $model;
    }*/
    /*public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->getResponse()->setStatusCode(204, 'Phase successfully deleted');
    }*/
    /*public function actionIndex()
    {
        $searchModel = new PhaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $dataProvider;
    }*/

} 