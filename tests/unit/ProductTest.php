<?php

use user\models\User;
use yii\helpers\Html;
use eav\models\DynamicField;
use tests\unit\fixtures\CategoryFixture;
use extended\helpers\Helper;
use tests\unit\fixtures\UserFixture;
use product\models\Product;
use tests\unit\fixtures\DynamicFieldFixture;
use tests\unit\fixtures\DynamicValueFixture;
use eav\models\DynamicValue;
use product\models\search\ProductSearchFrontend;
use tests\unit\fixtures\ProductFixture;
use yii\web\Request;
use yii\helpers\Url;
use product\models\Viewed;
use yii\web\UploadedFile;
use file\models\File;
use file\models\FileImage;
use product\models\FileImageProduct;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ProductTest extends \Codeception\Test\Unit
{
    //use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;


    public function _fixtures()
    {
        $fixtures = [
            'categories' => [
                'class' => CategoryFixture::class,
                'dataFile' => __DIR__ . '/test_fixtures/data/category.php',
                'depends'=>[],
            ],
            'dynamic_fields' => [
                'class' => DynamicFieldFixture::class,
                'dataFile' => __DIR__ . '/test_fixtures/data/dynamic_field.php',
                'depends' => [],
            ],
            'users' => [
                'class' => UserFixture::class,
                'depends'=>[],
            ],
        ];
        if(in_array($this->getName(), ['testCopy', 'testProductSearch',
            'testTypeProducts', 'testViewedProducts', 'testMultipleUpdate',
            'testGrouped', 'testGroupedViaAttribute', 'testBuyWithThis'])){
            $fixtures['products'] =[
                'class' => ProductFixture::class,
                'dataFile' => __DIR__ . '/test_fixtures/data/product.php',
                'depends' => [],
            ];
            $fixtures['dynamic_values'] =[
                'class' => DynamicValueFixture::class,
                'dataFile' => __DIR__ . '/test_fixtures/data/dynamic_value.php',
                'depends' => [],
            ];
        }
        if(in_array($this->getName(), ['testBuyWithThis']))
            $fixtures['buy_products'] =[
                'class' => \yii\test\ActiveFixture::class,
                'tableName'=>\product\models\ProductBuyWithThis::tableName(),
                'dataFile' => false,
                'depends' => [],
            ];

        return $fixtures;
    }

    protected function _before()
    {
        /*if(in_array($this->getName(), ['testCopy', 'testProductSearch',
            'testTypeProducts', 'testViewedProducts', 'testMultipleUpdate', 'testGrouped', 'testGroupedViaAttribute']))
            $this->tester->haveFixtures([
                'products' => [
                    'class' => ProductFixture::class,
                    'dataFile' => __DIR__ . '/test_fixtures/data/product.php',
                    'depends' => [],
                ],
                'dynamic_values' => [
                    'class' => DynamicValueFixture::class,
                    'dataFile' => __DIR__ . '/test_fixtures/data/dynamic_value.php',
                    'depends' => [],
                ],
            ]);*/

        $this->tester->mockUser();
        $this->tester->mockUrlManagerImg();
    }

    protected function _after()
    {
    }


    public function testProductCreate()
    {
        $category = $this->tester->grabFixture('categories', 0);
        $dynamic_field = $this->tester->grabFixture('dynamic_fields', 0);

        $productsFixture = new ProductFixture([
            'dataFile' => __DIR__ . '/test_fixtures/data/product.php',
            'depends' => [],
        ]);
        $data = $productsFixture->getData()[0];
        unset($data['id'], $data['category_id'], $data['user_id'],
            $data['title_url'], $data['created_at'], $data['updated_at']);


        $model = new Product();
        $model->category_id = $category->id;
        $model->trigger($model::EVENT_INIT_FIELDS_OF_MANY_TO_MANY);

        $model->trigger($model::EVENT_INIT_DYNAMIC_FIELDS);
        $model->setDynamicRules();


        $model->load($data, '');
        Yii::$app->request->setQueryParams([
            'processor' => 'i5',
        ]);
        $model->loadDynamicData();

        if ($model->isAttributeChanged('category_id')) {
            $model->trigger($model::EVENT_INIT_DYNAMIC_FIELDS);
            $model->setDynamicRules();
            $model->loadDynamicData();
            $dynamic_value = $model->valueModels[$dynamic_field->id];
            $this->tester->assertEquals($dynamic_value->value, 'i5');
        }

        $this->tester->assertTrue($model->save());
        $model->saveDynamicValues();
        $this->tester->seeRecord(DynamicValue::class, ['object_id' => $model->id,
            'field_id' => $dynamic_field->id,
            'value' => 'i5',
        ]);

        return $model;
    }
    public function testCreateUrl()
    {
        $product = $this->testProductCreate();

        $request = new Request();
        $request->cookieValidationKey = '123123';
        $request->baseUrl = Yii::$app->request->baseUrl;
        $request->scriptUrl = Yii::$app->request->scriptUrl;
        $request->url = $product->url;
        $route = $request->resolve()[0];
        $route = trim($route, "/");
        $route = preg_replace('/^(' . Yii::$app->language . '|mouse)|inend$/', '', $route);
        $route = trim($route, "/");
        $request->pathInfo = $route;
        $this->tester->assertNotNull($request->pathInfo);
        $this->tester->assertEquals($request->pathInfo, 'product/product/view');
    }
    public function testParseUrl()
    {
        $product = $this->testProductCreate();

        $request = Yii::$app->request;
        $request->setPathInfo($product->url);
        $request->resolve();

        $this->tester->assertNotNull($request->get('id'));
        $this->tester->assertEquals($request->get('id'), $product->id);
    }


    public function testCopy()
    {
        $model = $this->tester->grabFixture('products', 0);
        $model->trigger($model::EVENT_INIT_FIELDS_OF_MANY_TO_MANY);

        $model->trigger($model::EVENT_INIT_DYNAMIC_FIELDS);

        //new model
        $newModel = new Product();
        //assign attributes
        $newModel->attributes = $model->getAttributes(null, ['id', 'buyWithThisAttribute']);
        $newModel->title .= ' - copy';
        $newModel->trigger($newModel::EVENT_INIT_FIELDS_OF_MANY_TO_MANY);
        $newModel->buyWithThisAttribute = $model->buyWithThisAttribute;

        $newModel->trigger($newModel::EVENT_INIT_DYNAMIC_FIELDS);
        $newModel->setDynamicRules();
        foreach ($newModel->valueModels as $field_id => &$valueModel)
            $valueModel->attributes = $model->valueModels[$field_id]->getAttributes(null, ['id', 'object_id']);

        //images
        $images = [];
        foreach ($model->images as $n => $image) {
            $images[$n] = new UploadedFile;
            $images[$n]->name = 'copy-' . $image->title;
            $images[$n]->tempName = (new File)->copy($image->imageUrl, 'tmp copy ' . $image->file_name);
        }
        $newModel->imagesAttribute = $images;

        if ($newModel->save()) {
            //set main image
            if ($model->mainImage) {
                $image = $newModel->getImages()->andWhere(['title' => 'copy-' . $model->mainImage->title])->one();
                $image->updateAttributes(['type' => FileImage::TYPE_IMAGE_MAIN]);
            }
            $newModel->saveDynamicValues();
            $model->addToGroup($newModel->id);
        }
        $this->tester->assertNotEmpty($newModel->id);
        $this->checkGroup($model, $newModel);
    }

    protected function checkGroup($model, $nextModel)
    {
        $model->refresh();
        $nextModel->refresh();
        $this->tester->assertEquals($nextModel->group_id, $model->id);
        $this->tester->assertEquals($model->group_id, $model->id);
    }
    public function testGrouped()
    {
        $asus = $this->tester->grabFixture('products', 0);
        $asusCopy = $this->tester->grabFixture('products', 1);
        $asus->addToGroup($asusCopy->id);
        $this->checkGroup($asus, $asusCopy);
    }
    public function testGroupedViaAttribute()
    {
        /* @var $asus Product */

        $asus = $this->tester->grabFixture('products', 0);
        $asusCopy = $this->tester->grabFixture('products', 1);

        $asus->trigger($asus::EVENT_INIT_FIELDS_OF_MANY_TO_MANY);
        $asus->groupedProductsAttribute = [$asusCopy->id];

        $asus->save();

        $this->checkGroup($asus, $asusCopy);
    }
    public function testBuyWithThis()
    {
        /* @var $asus Product */

        $asus = $this->tester->grabFixture('products', 0);
        $bag = $this->tester->grabFixture('products', 4);

        $asus->trigger($asus::EVENT_INIT_FIELDS_OF_MANY_TO_MANY);
        $asus->buyWithThisAttribute = [$bag->id];

        $asus->save();

        $asus->refresh();
        $buyProducts = $asus->buyProducts;
        $this->tester->assertCount(1, $buyProducts);
        $this->tester->assertEquals($buyProducts[0]->id, $bag->id);
    }
    public function testMultipleUpdate()
    {
        Yii::$app->request->setBodyParams([
            'ids' => '1,2',
            (new Product)->formName() => [
                'price' => 600,
            ]
        ]);

        FileImageProduct::$deleteTempFile = false;
        $models = [];
        if (Yii::$app->request->post('ids'))
            $models = Product::findAll(explode(',', Yii::$app->request->post('ids')));

        $this->tester->assertCount(2, $models);

        foreach ($models as $n => $model) {
            $model->trigger($model::EVENT_INIT_FIELDS_OF_MANY_TO_MANY);

            $model->trigger($model::EVENT_INIT_DYNAMIC_FIELDS);
            $model->setDynamicRules();
            $model->loadDynamicData();

            if (isset(Yii::$app->request->post()[$model->formName()]))
                $model->attributes = Yii::$app->request->post()[$model->formName()];

            if ($model->isAttributeChanged('category_id')) {
                $model->trigger($model::EVENT_INIT_DYNAMIC_FIELDS);
                $model->setDynamicRules();
                $model->loadDynamicData();
            }

            $models[$n] = $model;
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validateMultiple($models);
        }

        foreach ($models as $model) {
            if ($model->save() && $model->saveDynamicValues())
                Yii::$app->session->addFlash('success', "ProductID:" . $model->id . " " . "Successfully saved.");
            else
                throw new \yii\base\Exception("ProductID:" . $model->id . " " .
                    Html::errorSummary($model, ['header' => false]));
        }

        $this->tester->assertEquals(2, Product::find()->andWhere(['price' => 600])->count());

    }

    protected function prepareDataProvider()
    {
        $searchModel = new ProductSearchFrontend();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $searchModel->trigger($searchModel::EVENT_INIT_DYNAMIC_FIELDS);
        $searchModel->loadDynamicData();
        $searchModel->eavSearch($dataProvider);
        return $dataProvider;
    }
    protected function checkCategoryIsNotSelected()
    {
        //category is not selected
        Yii::$app->request->setQueryParams([
            'category_id'=>'',
        ]);
        $this->tester->assertCount(4, $this->prepareDataProvider()->models);
    }
    protected function checkCategoryAndOptionIsSelected()
    {
        $category = $this->tester->grabFixture('categories', 0);

        //wrong category
        Yii::$app->request->setQueryParams([
            'category_id'=>1000000,
        ]);
        $this->tester->assertCount(0, $this->prepareDataProvider()->models);

        //write category & wrong option
        $request = Yii::$app->request;
        $request->setPathInfo($category->title_url);
        Yii::$app->request->setQueryParams([
            'processor'=>'i5',
        ]);
        $request->resolve();
        $this->tester->assertCount(0, $this->prepareDataProvider()->models);

        //write category and write option
        Yii::$app->request->setQueryParams([
            'processor'=>'i3',
        ]);
        $request->resolve();
        $this->tester->assertCount(1, $this->prepareDataProvider()->models);


        //price
        Yii::$app->request->setQueryParams([
            'priceFrom'=>800,
            'priceTo'=>600,
        ]);
        $this->tester->assertCount(0, $this->prepareDataProvider()->models);

        Yii::$app->request->setQueryParams([
            'priceFrom'=>700,
            'priceTo'=>1000,
        ]);
        $this->tester->assertCount(2, $this->prepareDataProvider()->models);

        Yii::$app->request->setQueryParams([
            'q'=>'asus1',
        ]);
        $this->tester->assertEmpty($this->prepareDataProvider()->models);

        Yii::$app->request->setQueryParams([
            'q'=>'good asus',
        ]);
        $this->tester->assertNotEmpty($this->prepareDataProvider()->models);

    }
    public function testProductSearch()
    {
        $this->checkCategoryIsNotSelected();
        $this->checkCategoryAndOptionIsSelected();
    }
    public function testViewedProducts()
    {
        $product = $this->tester->grabFixture('products', 0);


        $searchModel = new ProductSearchFrontend();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $query = $dataProvider->query;
        /* @var $query \product\models\query\ProductQuery */
        //Viewed::clearAll();
        $query->viewed();
        $this->tester->assertEmpty($dataProvider->models);


        Viewed::create($product->id);
        $dataProvider->query = Product::find()->viewed();
        $dataProvider->totalCount = null;
        $dataProvider->prepare(true);
        $this->tester->assertNotEmpty($dataProvider->models);
    }
    public function testTypeProducts()
    {
        $product = $this->tester->grabFixture('products', 0);
        $product2 = $this->tester->grabFixture('products', 1);

        $searchModel = new ProductSearchFrontend(['type'=>Product::TYPE_PROMOTE]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->tester->assertNotEmpty($dataProvider->models);

        $searchModel = new ProductSearchFrontend(['type'=>Product::TYPE_NOVELTY]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->tester->assertNotEmpty($dataProvider->models);

        $searchModel = new ProductSearchFrontend(['type'=>Product::TYPE_POPULAR]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->tester->assertNotEmpty($dataProvider->models);

        $product->type=[];
        $product2->type=[];
        $product->save();
        $product2->save();

        $searchModel = new ProductSearchFrontend(['type'=>Product::TYPE_PROMOTE]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->tester->assertEmpty($dataProvider->models);

        $searchModel = new ProductSearchFrontend(['type'=>Product::TYPE_NOVELTY]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->tester->assertEmpty($dataProvider->models);

        $searchModel = new ProductSearchFrontend(['type'=>Product::TYPE_POPULAR]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->tester->assertEmpty($dataProvider->models);
    }
}