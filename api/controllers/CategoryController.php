<?php

namespace api\controllers;

use category\models\Category;
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
class CategoryController extends \yii\rest\Controller
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
        ];
    }

    public function actionView($path)
    {
        $path = trim($path, '/');
        return Category::findOne(['title_url'=>$path]);
    }
    public function actionIndex()
    {
        $models = Category::find()->defaultOrder()->enabled()->indexBy('id')->with('image')
            ->all();
        foreach ($models as $model) {
            $model->trigger(Category::EVENT_INIT_POSITION_AND_PARENT_ID);
        }
        return $models;
    }


}
