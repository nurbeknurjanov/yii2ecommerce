<?php

namespace johnitvn\rbacplus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Html;
use johnitvn\rbacplus\Module;
use johnitvn\rbacplus\models\AssignmentSearch;
use johnitvn\rbacplus\models\AssignmentForm;

/**
 * AssignmentController is controller for manager user assignment
 *
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2016 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 
 */
class AssignmentController extends Controller {

    /**
     * The current rbac module
     * @var Module $rbacModule
     */
    protected $rbacModule;

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $this->rbacModule = Yii::$app->getModule('rbac');
    }

    /**
     * Show list of user for assignment
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AssignmentSearch;
        $dataProvider = $searchModel->search();
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'idField' => $this->rbacModule->userModelIdField,
                    'usernameField' => $this->rbacModule->userModelLoginField,
        ]);
    }

    /**
     * Assignment roles to user
     * @param mixed $id The user id
     * @return mixed
     */
    public function actionAssignment($id) {
        $model = call_user_func($this->rbacModule->userModelClassName . '::findOne', $id);
        $formModel = new AssignmentForm($id);
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isPost) {
                $formModel->load(Yii::$app->request->post());
                $save = $formModel->save();
            }
            return [
                'title' => $model->name,
                'forceClose' => $request->isPost && $save,
                'forceReload' => true,
                'content' => $this->renderPartial('assignment', [
                    'model' => $model,
                    'formModel' => $formModel,
                ]),
                'footer' => Html::button(Yii::t('rbac', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                Html::button(Yii::t('rbac', 'Save'), ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        } else {
            return $this->render('assignment', [
                        'model' => $model,
                        'formModel' => $formModel,
            ]);
        }
    }

}
