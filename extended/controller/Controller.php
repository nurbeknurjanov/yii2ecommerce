<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace extended\controller;

use yii\helpers\Url;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\ForbiddenHttpException;
use extended\helpers\Helper;

class Controller extends \yii\web\Controller
{

    public function goAlert($params = [])
    {
        return Yii::$app->getResponse()->redirect(['/site/alert', $params]);
    }

    public function actionAlert()
    {
        return $this->render('@frontend/views/site/alert');
    }

    protected function performAjaxValidation($model, $attributes = null)
    {

        if(!Yii::$app->request->isPjax && Yii::$app->request->isAjax)
        {
            if($model->load(Yii::$app->request->post()))
            {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                Yii::$app->response->data = ActiveForm::validate($model, $attributes); //never use it, use echo with die function instead of return
                Yii::$app->end();
            }
        }
    }

    public function afterAction($action, $result)
    {
        //Url::remember();
        $result = parent::afterAction($action, $result);
        // your custom code here
        return $result;
    }
    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }



    public function actionD()
    {
        foreach ([
                     'assets',
                     //'upload',
                     //'tmpUpload',
                     '../runtime',
                     '../../backend/web/assets',
                     '../../backend/runtime',
                 ] as $dir)
            Helper::emptydir($dir);
    }

}