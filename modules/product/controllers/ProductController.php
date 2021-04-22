<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace product\controllers;

use category\models\Category;
use comment\models\Comment;
use eav\models\DynamicField;
use eav\models\DynamicValue;
use extended\helpers\Helper;
use file\models\File;
use file\models\FileImage;
use product\models\FileImageProduct;
use product\models\query\ProductQuery;
use product\models\search\ProductSearchBackend;
use product\models\search\ProductSearchFrontend;
use product\models\Viewed;
use Yii;
use product\models\Product;
use product\models\search\ProductSearch;
use yii\db\Expression;
use yii\helpers\VarDumper;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use user\models\User;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use extended\controller\Controller;
use yii\web\Request;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @return string
     */

    public function init()
    {
        parent::init();
        if(strpos(Yii::$app->id, 'app-frontend')!==false)
            $this->defaultAction = 'list';
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action))
        {
            if(isset($_POST['viewStyle'])){
                Yii::$app->response->cookies->add(new Cookie([
                    'name' => 'viewStyle',
                    'value' => $_POST['viewStyle'],
                    'expire' => time() + 3600*24*7,
                ]));
            }
        }
        return true;
    }


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        //'roles' => [User::ROLE_USER],
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('createProduct');
                        }
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('updateProduct', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['copy'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('copyProduct', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('deleteProduct', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['index', 'multiple-update'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('indexProduct');
                        }
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('viewProduct', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['list', 'select', 'favorites', 'viewed', 'type', 'select-picker'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('listProduct');
                        }
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

    public function actionSelectPicker($q=null, array $value=null)
    {
        $query = (new Product)->getOrderedQuery($value, $q);

        $models = $query->all();
        $return = Html::tag('option', "Select", ['value'=>'']);
        foreach($models as $model)
            $return.=Html::tag('option', $model->title, ['value'=>$model->id,
                'selected'=>$value==$model->id || in_array($model->id,(array) $value)]);
        return $return;
    }

    /**
     * Lists all Product models.
     * @return mixed
     */

    public function actionIndex()
    {
        $searchModel = new ProductSearchBackend;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $query = $dataProvider->query;
        /* @var $query ProductQuery */
        if(!Yii::$app->user->can(User::ROLE_ADMINISTRATOR))
            $query->andWhere(['product.user_id'=>Yii::$app->user->id]);


        return $this->render('backend/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionMultipleUpdate()
    {
        FileImageProduct::$deleteTempFile=false;
        $models=[];
        if(Yii::$app->request->post('ids'))
            $models = Product::findAll(explode(',', Yii::$app->request->post('ids')));

        foreach ($models as $n=>$model){
            $model->trigger($model::EVENT_INIT_FIELDS_OF_MANY_TO_MANY);

            $model->trigger($model::EVENT_INIT_DYNAMIC_FIELDS);
            $model->setDynamicRules();
            $model->loadDynamicData();

            if(isset($_POST[$model->formName()]))
                $model->attributes = $_POST[$model->formName()];

            if($model->isAttributeChanged('category_id')){
                $model->trigger($model::EVENT_INIT_DYNAMIC_FIELDS);
                $model->setDynamicRules();
                $model->loadDynamicData();
            }

            $models[$n]=$model;
        }
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validateMultiple($models);
        }

        foreach ($models as $model){
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($model->save() && $model->saveDynamicValues())
                    Yii::$app->session->addFlash('success', "ProductID:".$model->id." "."Successfully saved.");
                else
                    Yii::$app->session->addFlash('error',"ProductID:".$model->id." ".
                        Html::errorSummary($model, ['header'=>false]));
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->addFlash('error', "ProductID:".$model->id." ".$e->getMessage());
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSelect($term=null)
    {
        $searchModel = new ProductSearchFrontend;
        $searchModel->q = $term;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModel->trigger($searchModel::EVENT_INIT_DYNAMIC_FIELDS);
        $searchModel->loadDynamicData();
        $searchModel->eavSearch($dataProvider);



        Yii::$app->response->format = Response::FORMAT_JSON;

        $term = Helper::cleanForMatchAgainst($term);
        $categories = Category::find()->defaultFrom()->whereByQTranslate($term)->all();

        $products = $dataProvider->models;
        $results = array_merge($categories, $products);

        return \extended\helpers\ArrayHelper::mapWithoutKey($results, function($model){
            return [
                'id'=>$model->id,
                'value'=>$model->title,
                'label'=>$model->title,
            ];
        });
    }

    public function getTitle(ProductSearchFrontend $searchModel, $dataProvider)
    {
        $fullPageCategoryTitle = null;
        $fullPageSearchTitle = null;
        $topTitle = null;
        $breadCrumbTitle = $menuTitle = $pageTitle = $title = Yii::t('product', 'All products');
        if($searchModel->category_id && $category = $searchModel->category){
            $pageTitle=null;
            $breadCrumbTitle = $menuTitle = $title = $category->title;
            if($category->hasChildren)
                $fullPageCategoryTitle = $title;
            else
                $pageTitle = $title;
        }

        foreach ($searchModel->valueModels as &$valueModel)
            if($valueModel->isNotEmpty)
                $title.=' - '.$valueModel->getValueText(',');

        if($searchModel->q){
            $menuTitle=null;
            $breadCrumbTitle = $topTitle = $title = Yii::t('common', 'Search results');

            $nProducts = Yii::t('product', '{n, plural, =0{no products} =1{# product} other{# products}} found.',
                ['n'=>$dataProvider->totalCount]);

            $fullPageSearchTitle = $pageTitle = Yii::t('product',
                'For query "{q}" - {nProducts}',
                ['nProducts'=>$nProducts, 'q'=>Html::encode($searchModel->q)]);
        }


        return [
            $title,
            $pageTitle,
            $fullPageCategoryTitle,
            $fullPageSearchTitle,
            $topTitle,
            $menuTitle,
            $breadCrumbTitle,
        ];
    }
    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new ProductSearchFrontend;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModel->trigger($searchModel::EVENT_INIT_DYNAMIC_FIELDS);
        $searchModel->loadDynamicData();
        $relationName = 'values';
        $viewStyle = Yii::$app->response->cookies->get('viewStyle')?:Yii::$app->request->cookies->get('viewStyle');
        if($viewStyle=='asList')
            $relationName = 'valuesWithFields';
        $searchModel->eavSearch($dataProvider, $relationName);

        //\Yii::beginProfile('blockProfile');
        //\Yii::endProfile('blockProfile');

        $titles = $this->getTitle($searchModel, $dataProvider);

        if(Yii::$app->request->isPjax){
            return $this->renderAjax('frontend/list/list', [
                'title'=>$titles[0],
                'pageTitle'=>$titles[1],
                'fullPageCategoryTitle'=>$titles[2],
                'fullPageSearchTitle'=>$titles[3],
                'topTitle'=>$titles[4],
                'menuTitle'=>$titles[5],
                'breadCrumbTitle'=>$titles[6],
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        return $this->render('frontend/list/list', [
            'title'=>$titles[0],
            'pageTitle'=>$titles[1],
            'fullPageCategoryTitle'=>$titles[2],
            'fullPageSearchTitle'=>$titles[3],
            'topTitle'=>$titles[4],
            'menuTitle'=>$titles[5],
            'breadCrumbTitle'=>$titles[6],
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionList2()
    {
        if(Yii::$app->request->isPjax)
            Yii::$app->response->getHeaders()->set('X-PJAX-Url',Url::to(['/product/product/list2']));
        return "string";
    }
    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionFavorites()
    {
        $searchModel = new ProductSearchFrontend();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->favorite();

        $title = Yii::t('favorite', 'Favorites');

        if(Yii::$app->request->isPjax){
            return $this->renderAjax('frontend/list/list', [
                'title' => $title,
                'pageTitle' => $title,
                'topTitle'=>$title,
                'breadCrumbTitle'=>$title,
                'menuTitle'=>null,
                'fullPageCategoryTitle'=>null,
                'fullPageSearchTitle'=>null,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        return $this->render('frontend/list/list', [
            'title' => $title,
            'pageTitle' => $title,
            'topTitle'=>$title,
            'breadCrumbTitle'=>$title,
            'menuTitle'=>null,
            'fullPageCategoryTitle'=>null,
            'fullPageSearchTitle'=>null,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionType($type)
    {
        $searchModel = new ProductSearchFrontend(['type'=>$type]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        $title = $searchModel->typeText;

        if(Yii::$app->request->isPjax){
            return $this->renderAjax('frontend/list/list', [
                'title' => $title,
                'pageTitle' => $title,
                'topTitle'=>$title,
                'breadCrumbTitle'=>$title,
                'menuTitle'=>null,
                'fullPageCategoryTitle'=>null,
                'fullPageSearchTitle'=>null,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        return $this->render('frontend/list/list', [
            'title' => $title,
            'pageTitle' => $title,
            'topTitle'=>$title,
            'breadCrumbTitle'=>$title,
            'menuTitle'=>null,
            'fullPageCategoryTitle'=>null,
            'fullPageSearchTitle'=>null,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionViewed()
    {
        $searchModel = new ProductSearchFrontend();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->viewed();

        $title = Yii::t('product', 'Viewed products');

        if(Yii::$app->request->isPjax){
            return $this->renderAjax('frontend/list/list', [
                'title' => $title,
                'pageTitle' => $title,
                'topTitle'=>$title,
                'breadCrumbTitle'=>$title,
                'menuTitle'=>null,
                'fullPageCategoryTitle'=>null,
                'fullPageSearchTitle'=>null,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        return $this->render('frontend/list/list', [
            'title' => $title,
            'pageTitle' => $title,
            'topTitle'=>$title,
            'breadCrumbTitle'=>$title,
            'menuTitle'=>null,
            'fullPageCategoryTitle'=>null,
            'fullPageSearchTitle'=>null,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        Yii::$app->response->headers->add('X-PJAX-URL', Yii::$app->request->url);
        $model = $this->findModel($id);

        if(Yii::$app->id=='app-backend')
            return $this->render('backend/view', [
                'model' => $model,
            ]);

        if(!$model->enabled)
            throw new NotFoundHttpException('The requested page does not exist.');

        Viewed::create($model->id);
        return $this->render('frontend/view/view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $model->trigger($model::EVENT_INIT_FIELDS_OF_MANY_TO_MANY);

        $model->trigger($model::EVENT_INIT_DYNAMIC_FIELDS);
        $model->setDynamicRules();
        $model->loadDynamicData();

        if($model->load(Yii::$app->request->post())){
            if($model->isAttributeChanged('category_id')){
                $model->trigger($model::EVENT_INIT_DYNAMIC_FIELDS);
                $model->setDynamicRules();
                $model->loadDynamicData();
            }
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                return array_merge(ActiveForm::validateMultiple($model->valueModels), ActiveForm::validate($model));
            }
            if ($model->save()){
                $model->saveDynamicValues();
                return $this->redirect(['index']);
                //return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('backend/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->trigger($model::EVENT_INIT_FIELDS_OF_MANY_TO_MANY);
        $model->trigger($model::EVENT_INIT_DYNAMIC_FIELDS);
        $model->setDynamicRules();
        $model->loadDynamicData();

        if($model->load(Yii::$app->request->post())){
            if($model->isAttributeChanged('category_id')){
                $model->trigger($model::EVENT_INIT_DYNAMIC_FIELDS);
                $model->setDynamicRules();
                $model->loadDynamicData();
            }
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                return array_merge(ActiveForm::validateMultiple($model->valueModels), ActiveForm::validate($model));
            }
            if ($model->save()){
                $model->saveDynamicValues();
                return $this->redirect(['index']);
                //return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('backend/update', [
            'model' => $model,
        ]);
    }

    public function actionCopy($id)
    {
        //model that we wanna copy
        $model = $this->findModel($id);
        $model->trigger($model::EVENT_INIT_FIELDS_OF_MANY_TO_MANY);

        $model->trigger($model::EVENT_INIT_DYNAMIC_FIELDS);

        //new model
        $newModel = new Product();
        //assign attributes
        $newModel->attributes = $model->getAttributes(null, ['id', 'buyWithThisAttribute']);
        $newModel->title.=' - copy';
        $newModel->trigger($newModel::EVENT_INIT_FIELDS_OF_MANY_TO_MANY);
        $newModel->buyWithThisAttribute = $model->buyWithThisAttribute;

        $newModel->trigger($newModel::EVENT_INIT_DYNAMIC_FIELDS);
        $newModel->setDynamicRules();
        foreach ($newModel->valueModels as $field_id => &$valueModel)
            $valueModel->attributes = $model->valueModels[$field_id]->getAttributes(null, ['id', 'object_id']);

        //images
        $images = [];
        foreach ($model->images as $n=>$image){
            $images[$n] = new UploadedFile;
            $images[$n]->name = 'copy-'.$image->title;
            $images[$n]->tempName =  (new File)->copy($image->imageUrl, 'tmp copy '.$image->file_name) ;
        }
        $newModel->imagesAttribute = $images;

        if ($newModel->save()){
            //set main image
            if($model->mainImage){
                $image = $newModel->getImages()->andWhere(['title'=>'copy-'.$model->mainImage->title])->one();
                $image->updateAttributes(['type'=>FileImage::TYPE_IMAGE_MAIN]);
            }
            $newModel->saveDynamicValues();
            $model->addToGroup($newModel->id);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('success', 'You have successfully deleted the item.');
            if(strpos(Yii::$app->request->referrer,'view')!==false)
                return $this->redirect($this->defaultAction);
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * Finds the Product model based on its primary key value.
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


}
