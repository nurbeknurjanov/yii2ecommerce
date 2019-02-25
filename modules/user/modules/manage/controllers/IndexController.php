<?php

namespace user_manage\controllers;

use user\controllers\UserController;
use user\models\create\TokenCreate;
use user\models\search\UserSearch;

use user\models\Token;

use yii\base\Exception;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\Response;
use user\models\User;


class IndexController extends UserController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'select', 'enable', 'disable', 'reset-password'],
                        'allow' => true,
                        //'roles' => [User::ROLE_MANAGER],
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('indexUser');
                        }
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('createUser');
                        }
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                                if(!isset($_GET['id']))
                                    throw new Exception("id parameter is missing");
                                return Yii::$app->user->can('updateUser', ['model' => $this->findModel($_GET['id'])]);
                            }
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                                if(!isset($_GET['id']))
                                    throw new Exception("id parameter is missing");
                                return Yii::$app->user->can('viewUser', ['model' => $this->findModel($_GET['id'])]);
                            }
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                                if(!isset($_GET['id']))
                                    throw new Exception("id parameter is missing");
                                return Yii::$app->user->can('deleteUser', ['model' => $this->findModel($_GET['id'])]);
                            }
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $token = TokenCreate::create(Token::ACTION_COMPLETE_ACCOUNT, $model);
            Yii::$app->mailer->compose('completeAccount-html', ['user' => $model, 'token'=>$token,])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setTo([$model->email=>$model->fullName])
                ->setSubject(Yii::t('common', 'You have registered by administrator. Here is a link to activate your account.'))
                ->send();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->save())
            return $this->redirect(['view', 'id' => $model->id]);
        else
            return $this->render('update', [
                'model' => $model,
            ]);
        }

    public function actionResetPassword($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'resetByAdministrator';
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->setPassword($model->password_new);
            $model->save(false);
            Yii::$app->session->setFlash('successMessage', Yii::t('common', 'You successfully changed password'));
            return $this->refresh();
        } else {
            return $this->render('reset', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
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
        if(isset($_POST['returnUrl']))
            return $this->redirect($_POST['returnUrl']);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDisable($id)
    {
        $model = $this->findModel($id);
        $model->status = User::STATUS_INACTIVE;
        $model->save();
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionEnable($id)
    {
        $model = $this->findModel($id);
        $model->activateStatus();
        return $this->redirect(Yii::$app->request->referrer);
    }

}
