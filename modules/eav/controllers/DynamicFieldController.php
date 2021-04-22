<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace eav\controllers;

use category\models\Category;
use eav\models\DynamicValue;
use product\models\Product;
use Yii;
use eav\models\DynamicField;
use eav\models\search\DynamicFieldSearch;
use extended\controller\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use user\models\User;

/**
 * DynamicFieldController implements the CRUD actions for DynamicField model.
 */
class DynamicFieldController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'except' => ['select', 'select-for-search', 'select-for-search-in-backend'],
                'rules' => [
                    [
                        'actions' => ['create', 'view', 'update', 'delete', 'index'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMINISTRATOR],
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



    public function actionSelectForSearch($category_id)
    {
        /* @var DynamicField[] $fieldModels */
        /* @var DynamicValue[] $valueModels */
        $fieldModels = DynamicField::find()
            ->defaultFrom()
            ->defaultOrder()
            ->enabled()
            ->categoryQuery($category_id, true, true, true)
            ->in_search()
            ->indexBy('id')->all();
        foreach ($fieldModels as &$fieldModel){
            $valueModel = $fieldModel->valueObject;
            $valueModel->loadRequestData();
            $valueModel->_fieldObject = $fieldModel;
            $valueModels[$fieldModel->key] = $valueModel;
        }
        $form = new ActiveForm([
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
        ]);
        return $this->renderPartial('fields/_fields_for_search', ['valueModels'=>$valueModels, 'form'=>$form]);
    }
    public function actionSelect($category_id, $object_id=null)
    {
        $fieldModels = DynamicField::find()
            ->defaultFrom()
            ->defaultOrder()
            ->enabled()
            ->categoryQuery($category_id, true, true, true)
            ->indexBy('id')->all();

        foreach ($fieldModels as &$fieldModel){
            $valueModel = $fieldModel->getValueObject($object_id);
            $valueModel->setDynamicRules();
            $valueModel->loadRequestData();
        }

        $form = new ActiveForm([
            'id'=>'productForm',
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-9\" >{input}</div>\n<div class=\"col-lg-9 col-lg-offset-3\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-3 control-label'],
            ],
        ]);

        return $this->renderPartial('fields/_fields', [
            'fieldModels'=>$fieldModels,
            'object_id'=>$object_id,
            'form'=>$form,
        ]);
    }
    public function actionSelectForSearchInBackend($category_id)
    {
        /* @var DynamicField[] $fieldModels */
        $fieldModels = DynamicField::find()
            ->defaultFrom()
            ->defaultOrder()
            ->enabled()
            ->categoryQuery($category_id, true, true, true)
            ->indexBy('id')->all();
        foreach ($fieldModels as &$fieldModel){
            $valueModel = $fieldModel->valueObject;
            $valueModel->loadRequestData();
        }

        $form = new ActiveForm([
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
        ]);

        return $this->renderPartial('fields/_fields', [
            'fieldModels'=>$fieldModels,
            'form'=>$form,
            'object_id'=>null,
        ]);
    }

    /**
     * Lists all DynamicField models.
     * @return mixed
     */

    public function actionIndex()
    {
        $searchModel = new DynamicFieldSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DynamicField model.
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
     * Creates a new DynamicField model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DynamicField();
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DynamicField model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DynamicField model.
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
     * Finds the DynamicField model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DynamicField the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DynamicField::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
