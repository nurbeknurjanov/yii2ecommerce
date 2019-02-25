<?php

namespace like\controllers;

use Yii;
use like\models\Like;
use like\models\search\LikeSearch;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use user\models\User;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use extended\controller\Controller;
use yii\web\Response;
use common\widgets\Alert;

/**
 * LikeController implements the CRUD actions for Like model.
 */
class LikeController extends Controller
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
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['model_id']))
                                throw new Exception("model_id parameter is missing");
                            if(!isset($_GET['model_name']))
                                throw new Exception("model_name parameter is missing");
                            $commentModel = $_GET['model_name']::findOne($_GET['model_id']);
                            return Yii::$app->user->can('createLike', ['object' => $commentModel]);
                        }
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('indexLike');
                        }
                    ],
                    /*[
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => [User::ROLE_TEACHER, User::ROLE_PARENT],
                        'matchCallback' => function($rule, $action){
                                if(!isset($_GET['id']))
                                    throw new Exception("id parameter is missing");
                                return Yii::$app->user->can('updateLike', ['model' => $this->findModel($_GET['id'])]);
                            }
                    ],*/
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('deleteLike', ['model' => $this->findModel($_GET['id'])]);
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
     * Lists all Like models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LikeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Like model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Like model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($model_id, $model_name, $mark=null)
    {

        $model = new Like(['model_id'=>$model_id, 'model_name'=>$model_name, 'mark'=>$mark]);
        $this->performAjaxValidation($model);

        if(Yii::$app->request->isPost)
            $model->load(Yii::$app->request->post(), '');

        if ($model->save())
            Yii::$app->session->setFlash('success', Yii::t('like', "You successfully voted."));
        else
            Yii::$app->session->setFlash('error', Html::errorSummary($model));

        if(Yii::$app->request->headers->get('returnOnlyAlert')){
            $return = [];
            Yii::$app->response->format = Response::FORMAT_JSON;
            foreach (Yii::$app->session->getAllFlashes() as $type => $message) {
                $return['type']=$type;
                $return['message']=Yii::$app->session->getFlash($type, null, true);
                //$session->removeFlash($type);
            }
            return $return;
        }
        if(Yii::$app->request->isPjax)
            Yii::$app->response->headers->add('X-PJAX-URL', Yii::$app->request->referrer);
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Updates an existing Like model.
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
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Like model.
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
     * Finds the Like model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Like the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Like::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
