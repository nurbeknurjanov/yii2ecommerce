<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 10/25/16
 * Time: 1:19 AM
 */

namespace product\controllers;


use extended\controller\Controller;
use product\models\Compare;
use product\models\Product;
use yii\helpers\VarDumper;
use yii\web\Response;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\Exception;
use product\models\search\ProductSearchFrontend;
use Yii;

class CompareController extends Controller
{

    public function actionAdd($id)
    {
        $model = Product::findOne($id);
        if($model){
            Compare::create($model);
            Yii::$app->session->setFlash('success', Yii::t('product', 'You successfully added the item into compare.'));
        }else
            Yii::$app->session->setFlash('error', "Something is wrong.");


        if(Yii::$app->request->headers->get('returnOnlyAlert'))
        {
            $return = [];
            $return['count'] = Compare::getCount();
            $return['compareMessage'] = Compare::getNProducts();
            Yii::$app->response->format = Response::FORMAT_JSON;
            foreach (Yii::$app->session->getAllFlashes() as $type => $message) {
                $return['type']=$type;
                $return['message']=Yii::$app->session->getFlash($type, null, true);
            }
            return $return;
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRemove($id)
    {

        try {
            Compare::delete($id);
            Yii::$app->session->setFlash('success', Yii::t('product', 'You successfully removed the item from compare.'));
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        if(Yii::$app->request->headers->get('returnOnlyAlert')){
            $return = [];
            $return['count'] = Compare::getCount();
            $return['compareMessage'] = Compare::getNProducts();
            Yii::$app->response->format = Response::FORMAT_JSON;
            foreach (Yii::$app->session->getAllFlashes() as $type => $message) {
                $return['type']=$type;
                $return['message']=Yii::$app->session->getFlash($type, null, true);
                //$session->removeFlash($type);
            }
            return $return;
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionIndex()
    {
        $models = Product::find()->compare()->enabled()->with("valuesWithFields")->all();
        if(!$models)
            Yii::$app->session->setFlash('warning', Yii::t('product', 'You didn\'t select the items to compare.'));
        return $this->render('compare', [
            'models' => $models,
        ]);
    }
}