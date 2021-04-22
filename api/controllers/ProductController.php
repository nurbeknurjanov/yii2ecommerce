<?php

namespace api\controllers;


use category\models\Category;
use eav\models\DynamicField;
use page\models\Page;
use product\models\Product;
use product\models\query\ProductQuery;
use product\models\search\ProductSearchFrontend;
use user\models\User;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\VarDumper;
use yii\rest\ActiveController;
use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\rest\IndexAction;
use yii\rest\Serializer;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;




class ProductController extends ActiveController
{
    public $serializer = \extended\controller\Serializer::class;
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors'=>[
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [
                        'X-Pagination-Total-Count',
                        'X-Pagination-Per-Page',
                        'X-Pagination-Current-Page',
                        'X-Pagination-Page-Count',//how much count of divided pages
                    ],
                ],
            ],
        ];
    }
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);

        /*$actions['index'] = [
            'class' => IndexAction::class,
            'modelClass' => $this->modelClass,
            'prepareDataProvider' =>  function ($action) {
                $searchModel = new ProductSearchFrontend();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $searchModel->trigger($searchModel::EVENT_INIT_DYNAMIC_FIELDS);
                $searchModel->loadDynamicData();
                $searchModel->eavSearch($dataProvider);

                //$dataProvider->query->andWhere(['product.id'=>2]);
                //$dataProvider->query->favorite();
                return $dataProvider;
            }
        ];*/

        return $actions;
    }


    public $modelClass = Product::class;

    /**
     * Finds the Phase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    public function actionIndex()
    {
        $searchModel = new ProductSearchFrontend();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModel->trigger($searchModel::EVENT_INIT_DYNAMIC_FIELDS);
        $searchModel->loadDynamicData();
        $relationName = 'values';
        $viewStyle = Yii::$app->response->cookies->get('viewStyle')?:Yii::$app->request->cookies->get('viewStyle');
        if($viewStyle=='asList')
            $relationName = 'valuesWithFields';
        $searchModel->eavSearch($dataProvider, $relationName);

        /* @var $query ProductQuery */
        $query = $dataProvider->query;
        if(Yii::$app->request->get('ids'))
            $query->andWhere(['product.id'=>Yii::$app->request->get('ids')]);

        $titles = (new \product\controllers\ProductController('product', Yii::$app))->getTitle($searchModel,$dataProvider);


        return [
            'title'=>$titles[0],
            'pageTitle'=>$titles[1],
            'fullPageCategoryTitle'=>$titles[2],
            'fullPageSearchTitle'=>$titles[3],
            'topTitle'=>$titles[4],
            'menuTitle'=>$titles[5],
            'breadCrumbTitle'=>$titles[6],
            'products'=>$this->serializeData($dataProvider),
        ];
    }
    public function actionIndex1()
    {
        $searchModel = new ProductSearchFrontend();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModel->trigger($searchModel::EVENT_INIT_DYNAMIC_FIELDS);
        $searchModel->loadDynamicData();
        $relationName = 'values';
        $viewStyle = Yii::$app->response->cookies->get('viewStyle')?:Yii::$app->request->cookies->get('viewStyle');
        if($viewStyle=='asList')
            $relationName = 'valuesWithFields';
        $searchModel->eavSearch($dataProvider, $relationName);
        //$dataProvider->query->favorite();
        //$dataProvider->query->andWhere(['product.id'=>2]);


        $titles = (new \product\controllers\ProductController('product', Yii::$app))->getTitle($searchModel,$dataProvider);

        $category = $searchModel->category;
        $parentCategories = [];
        $childrenCategories = [];
        if($category){
            foreach ($category->parents()->all() as $parent)
                $parentCategories[] = $parent;

            $childrenCategories = Category::getDb()->cache(function ($db) use($category) {
                return $category->children(1)->enabled()->with('image')->all();
            });
        }

        return [
            'title'=>$titles[0],
            'pageTitle'=>$titles[1],
            'fullPageCategoryTitle'=>$titles[2],
            'fullPageSearchTitle'=>$titles[3],
            'topTitle'=>$titles[4],
            'menuTitle'=>$titles[5],
            'breadCrumbTitle'=>$titles[6],
            'eavBlock'=>$this->renderAjax('@product/views/layouts/_sidebar_eav', ['searchModel' => $searchModel]),
            'products'=>$this->serializeData($dataProvider),
            'category'=>$this->serializeData($category),
            'parentCategories'=>$this->serializeData($parentCategories),
            'childrenCategories'=>$this->serializeData($childrenCategories),
        ];
    }
    public function actionFavorites($ids)
    {
        $searchModel = new ProductSearchFrontend();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $query = $dataProvider->query;
        if($ids)
            $query->andWhere(['product.id'=>explode(',',$ids)]);
        else
            $query->andWhere(['product.id'=>'not']);

        //$dataProvider->query->favorite();


        $title = Yii::t('favorite', 'Favorites');

        return [
            'title' => $title,
            'pageTitle' => $title,
            'topTitle'=>$title,
            'breadCrumbTitle'=>$title,
            'eavBlock'=>$this->renderAjax('@product/views/layouts/_sidebar_eav', ['searchModel' => $searchModel]),
            'products'=>$this->serializeData($dataProvider),
        ];
    }

    public function actionCompare($ids)
    {
        $query = Product::find();
        if($ids)
            $query->andWhere(['product.id'=>explode(',',$ids)]);
        else
            $query->andWhere(['product.id'=>'not']);
        $models = $query->enabled()->with("valuesWithFields")->all();
        if(!$models)
            Yii::$app->session->setFlash('warning', Yii::t('product', 'You didn\'t select the items to compare.'));


        $title = Yii::t('product', 'Compare products');

        $keys=[];
        foreach ($models as $model)
            $keys = array_merge($keys, array_keys($model->valuesWithFields));
        $keys = array_unique($keys);
        $fields = DynamicField::find()->andWhere(['key'=>$keys])->all();
        return [
            'title' => $title,
            'pageTitle' => $title,
            'topTitle'=>$title,
            'breadCrumbTitle'=>$title,
            'fields'=>$this->serializeData($fields),
            'products'=>$this->serializeData($models),
        ];
    }

    public function actionFindAllById($ids)
    {
        $query = Product::find();
        if($ids)
            $query->andWhere(['product.id'=>explode(',',$ids)]);
        else
            $query->andWhere(['product.id'=>'not']);
        $models = $query->enabled()->with("valuesWithFields")->indexBy('id')->all();

        return $this->serializeData($models);

    }


} 