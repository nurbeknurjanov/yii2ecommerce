<?php

use user\models\User;
use yii\helpers\Html;
use eav\models\DynamicField;
use tests\unit\fixtures\CategoryFixture;
use extended\helpers\Helper;
use Codeception\Util\Fixtures;
use tests\unit\fixtures\DynamicFieldFixture;
use product\models\search\ProductSearchFrontend;

class DynamicFieldTest extends \Codeception\Test\Unit
{
    //use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;


    public function _fixtures()
    {
        return [
            'categories' => [
                'class' => CategoryFixture::class,
                'dataFile' => __DIR__.'/test_fixtures/data/category.php',
                'depends'=>[],
            ],
            'dynamic_fields_null'=>[
                'class'=>DynamicFieldFixture::class,
                'depends'=>[],
                'dataFile' => false
            ],
        ];
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    protected function createDynamicField()
    {
        $category = $this->tester->grabFixture('categories', 0);

        $dynamicFieldsFixture = new DynamicFieldFixture([
            'dataFile' => __DIR__.'/test_fixtures/data/dynamic_field.php',
            'depends'=>[],
        ]);
        $data = $dynamicFieldsFixture->getData()[0];
        unset($data['id'], $data['category_id']);

        $dynamicField = new DynamicField($data);
        $dynamicField->category_id=$category->id;
        $dynamicField->save();
        return $dynamicField;
    }
    public function testDynamicFieldCreate()
    {

        $dynamicField = $this->createDynamicField();

        $this->tester->assertNotNull($dynamicField->id);

        //Yii::info(Yii::$app->id);
        /*
        $id = $this->tester->haveRecord(User::className(), [
            'username' => 'new',
            'email' => 'new@mail.ru',
            'name' => 'new',
            'institution_id' => 15,
            'status' => User::STATUS_ACTIVE,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        // access model
        $user = User::findOne($id);
        $user->name = 'new1';
        $user->save();

        $this->tester->assertEquals('new1', $user->getFullName());
        $this->tester->seeRecord(User::className(), ['name' => 'new1']);
        $this->tester->dontSeeRecord(User::className(), ['name' => 'new']);
        */
        /*$this->specify("It must not be found with name new2", function()  {
        });*/
        //verify($user->getFullName())->equals('new3');
        //\Codeception\Util\Debug::debug($this->em);
    }
    public function testDynamicFieldAppearsOnCategory()
    {
        $category = $this->tester->grabFixture('categories', 0);
        $dynamicField = $this->createDynamicField();

        $searchModel = new ProductSearchFrontend();


        $dynamicField->category_id=null;
        $dynamicField->save();
        $searchModel->trigger($searchModel::EVENT_INIT_DYNAMIC_FIELDS);
        $this->tester->assertEquals(count($searchModel->valueModels), 1);

        $dynamicField->category_id=$category->id;
        $dynamicField->save();
        $searchModel->trigger($searchModel::EVENT_INIT_DYNAMIC_FIELDS);
        $this->tester->assertEquals(count($searchModel->valueModels), 0);


        $searchModel->search(['category_id'=>$category->id]);
        Yii::$app->request->setQueryParams([
            'processor'=>'i3',
        ]);
        //$searchModel->search(Yii::$app->request->queryParams);
        $searchModel->trigger($searchModel::EVENT_INIT_DYNAMIC_FIELDS);
        $searchModel->loadDynamicData();
        $this->tester->assertCount(1, $searchModel->valueModels);
        $valueModel = $searchModel->valueModels[$dynamicField->id];
        $this->tester->assertEquals($valueModel->value, 'i3');

    }
}