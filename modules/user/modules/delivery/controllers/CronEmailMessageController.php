<?php

namespace delivery\controllers;

use user\models\User;
use Yii;
use delivery\models\CronEmailMessage;
use delivery\models\search\CronEmailMessageSearch;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CronEmailMessageController implements the CRUD actions for CronEmailMessage model.
 */
class CronEmailMessageController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['view', 'delete', 'index', 'update', 'send-messages'],
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

    /**
     * Lists all CronEmailMessage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CronEmailMessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionSendMessages()
    {
        $cronEmailMessages = CronEmailMessage::find()->open()->limit(10)->all();
        foreach ($cronEmailMessages as $cronEmailMessage) {
            try {
                Yii::$app->mailer->compose()
                    ->setTo([$cronEmailMessage->recipient_email=>$cronEmailMessage->recipient_name])
                    ->setFrom([$cronEmailMessage->sender_email => $cronEmailMessage->sender_name])
                    ->setSubject($cronEmailMessage->subject)
                    ->setTextBody($cronEmailMessage->body)
                    ->send();

                $cronEmailMessage->status = CronEmailMessage::STATUS_SENT;
                $cronEmailMessage->sent_date = date('Y-m-d H:i:s');
                $cronEmailMessage->save();
                Yii::trace("Message sent successfully", 'sendMessageMailer');
            } catch (Exception $e) {
                Yii::error($e->getMessage(), 'sendMessageMailer');
                return $e->getMessage();
            }
        }
        return null;
    }

    /**
     * Displays a single CronEmailMessage model.
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
     * Creates a new CronEmailMessage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CronEmailMessage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CronEmailMessage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CronEmailMessage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CronEmailMessage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CronEmailMessage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CronEmailMessage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
