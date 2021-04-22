<?php

namespace api\controllers;

use category\models\Category;
use eav\models\DynamicField;
use eav\models\DynamicField as DF;
use extended\helpers\MenuTree;
use user\models\create\TokenCreate;
use user\models\User;
use user\models\Token;
use user\models\LoginForm;
use Yii;
use yii\base\Exception;
use yii\bootstrap\Nav;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use extended\controller\Controller;

/**
 */
class DynamicFieldController extends \yii\rest\Controller
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
        ];
    }


    public function actionIndex()
    {
        $models = DynamicField::find()->defaultOrder()
            ->enabled()
            ->andWhere(['type'=>[DF::TYPE_DROP_DOWN_LIST,
                DF::TYPE_DROP_DOWN_LIST_MULTIPLE,
                DF::TYPE_RADIO_LIST,DF::TYPE_CHECKBOX_LIST ]])
            ->all();
        return $models;
    }


}
