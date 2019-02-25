<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\controllers;


use Yii;
use file\models\File;
use extended\controller\Controller;
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
 * FileController implements the CRUD actions for File model.
 */
class FileController extends Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [ 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function($rule, $action)
                            {
                                if(!isset($_GET['id']))
                                    throw new Exception("id parameter is missing");
                                $file =$this->findModel($_GET['id']);
                                return Yii::$app->user->can('update'.$file->shortModelName, ['model' => $file->model]);
                            }
                    ],
                ],
            ],
        ];
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        try {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Successfully deleted.');
            //return $this->redirect(Yii::$app->request->referrer);
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        if( !Yii::$app->request->isPjax && Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [];
        }
        return $this->redirect(Yii::$app->request->referrer);
    }



    /**
     * Finds the File model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return File the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = File::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
