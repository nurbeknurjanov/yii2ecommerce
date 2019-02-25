<?php

use yii\web\Request;
use yii\helpers\Url;
use tests\unit\fixtures\CategoryFixture;
use category\models\Category;

class CategoryUnitTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _fixtures()
    {
        return [
            'categories' => [
                'class' => CategoryFixture::class,
                'dataFile' => false,
                'depends'=>[],
            ],
        ];
    }

    public function _before()
    {
    }

    protected function _after()
    {
    }

    protected function createCategory()
    {
        $categoriesFixture = new CategoryFixture([
            'dataFile' => __DIR__.'/test_fixtures/data/category.php'
        ]);
        $data = $categoriesFixture->getData()[0];
        unset($data['id']);

        $category = new Category($data);
        $category->makeRoot();
        return $category;
    }
    public function testCategoryCreate()
    {
        $category = $this->createCategory();
        $this->tester->assertNotNull($category->id);
    }
    public function testUrlOfCategory()
    {
        $category = $this->createCategory();
        $this->tester->assertNotNull($category->title_url);
        $this->tester->assertEquals($category->title_url, 'computer');

        /*sleep(1);
Yii::info(date('Y-m-d H:i:s').'----------------'.__FILE__);*/

        /*$user = \Codeception\Stub::make('user\models\User',
            [
                'getFullName' => 'john',
            ]);*/
        //Yii::info($user->getFullName());

        /*$user = $this->make('user\models\User', [
            //'getFullName' => Expected::never(),//nikogda ne budet vizivatsya
            'getFullName' => Expected::atLeastOnce('john')
            //'someMethod' => function() {}
        ]);*/
        //$user->someMethod();
    }

    public function testCreateUrl()
    {
        //$category = $this->tester->grabFixture('categories', 0);
        $category = $this->createCategory();

        Yii::$app->urlManager->showScriptName=false;

        $this->tester->assertEquals(Url::to($category->url), '/'.$category->title_url);
    }
    public function testParseUrl()
    {
        $category = $this->createCategory();

        $request = Yii::$app->request;
        $request->setPathInfo($category->title_url);
        $request->resolve();

        $this->tester->assertNotNull($request->get('category_id'));
        $this->tester->assertEquals($request->get('category_id'), $category->id);
    }


}