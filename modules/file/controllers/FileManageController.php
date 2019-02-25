<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\controllers;



use file\models\search\FileSearch;
use Yii;
use file\models\File;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use user\models\User;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\web\Response;

/**
 * FileManageController implements the CRUD actions for File model.
 */
class FileManageController extends \file\controllers\FileController
{

    public function behaviors()
    {
        $behaviours = parent::behaviors();
        return ArrayHelper::merge($behaviours, [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [ 'index', 'view', 'update'],
                        'allow' => true,
                        'roles' => [User::ROLE_MANAGER],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Lists all File models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single File model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

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

}
