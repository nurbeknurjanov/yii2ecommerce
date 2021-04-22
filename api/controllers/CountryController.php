<?php

namespace api\controllers;

use category\models\Category;
use country\models\City;
use country\models\Country;
use country\models\Region;
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
class CountryController extends \yii\rest\Controller
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
        ];
    }


    public function actionCountries()
    {
        $models = Country::find()->all();
        return $models;
    }

    public function actionRegions($country_id)
    {
        $models = Region::find()->countryQuery($country_id)->all();
        return $models;
    }

    public function actionCities($region_id)
    {
        $models = City::find()->regionQuery($region_id)->all();
        return $models;
    }


}
