<?php

namespace comment\controllers;

use product\models\Product;
use Yii;
use comment\models\Comment;
use comment\models\search\CommentSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use user\models\User;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use extended\controller\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use common\widgets\Alert;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['create-frontend'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['model_id']))
                                throw new Exception("model_id parameter is missing");
                            if(!isset($_GET['model_name']))
                                throw new Exception("model_name parameter is missing");
                            $product = $_GET['model_name']::findOne($_GET['model_id']);
                            if(!$product)
                                throw new Exception("Object not found");
                            return Yii::$app->user->can('createComment', ['object'=>$product] );
                        }
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('indexComment');
                        }
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('updateComment', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('deleteComment', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('viewComment', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['list'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('listComment');
                        }
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('indexComment');
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
     * Lists all Comment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all Comment models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new CommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('frontend/list/list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Comment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreateFrontend($model_id, $model_name)
    {
        $product = $model_name::findOne($model_id);
        if(!$product)
            throw new Exception("Object not found");

        $model = new Comment(['model_id'=>$model_id, 'model_name'=>$model_name]);
        $rating = $model->ratingObject;

        if($model->load($_POST) && $rating->load($_POST))
        {
            if(Yii::$app->request->isAjax && !Yii::$app->request->isPjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return array_merge(ActiveForm::validate($rating), ActiveForm::validate($model));
            }

            if ($model->save())
                Yii::$app->session->setFlash('success',Yii::t('comment', 'Review successfully leaved.') );
            else
                Yii::$app->session->setFlash('error',Html::errorSummary($model));

            if(Yii::$app->request->isPjax)
                return Alert::widget();
                //return Html::tag("div", Alert::widget(), ['id'=>'newCommentPjax']);
            else
                return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('frontend/create/_create_comment_for_product', [
            'model' => $model,
            'object' => $product,
        ]);
    }

    /**
     * Creates a new Comment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comment();
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Updates an existing Comment model.
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
     * Deletes an existing Comment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('success',Yii::t('comment', 'Review successfully deleted.') );
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        /*if(Yii::$app->request->isPjax)
            return Alert::widget();
        else*/
            return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * Finds the Comment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
