<?php

namespace api\controllers;


use i18n\models\I18nMessage;
use user\models\User;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;




class MessageController extends ActiveController
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
        ];
    }
    public function actions()
    {
        $actions = parent::actions();

        return $actions;
    }
    public $modelClass = I18nMessage::class;

    /**
     * Finds the Phase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return I18nMessage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = I18nMessage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionT($category, $word)
    {
        $params = Yii::$app->request->queryParams;
        unset($params['category']);
        unset($params['word']);
        if($word=='nProducts')
            $word='{n, plural, =0{no products} =1{# product} other{# products}}';
        if($word=='nProductsForAmount'){
            $nProducts = Yii::t('order', '{n, plural, =0{no products} =1{# product} other{# products}}', ['n'=>$params['n']]);
            return Yii::t('order', "{nProducts} for {amount}",
                [
                    'amount'=>Yii::$app->formatter->asCurrency($params['amount']),
                    'nProducts'=>$nProducts
                ]);
        }
        return Yii::t($category, $word, $params);
    }

} 