<?php

use yii\helpers\Url;
use user\models\Token;
use yii\test\ActiveFixture;
use user\models\LoginForm;
use user\models\User;
use tests\unit\fixtures\CategoryFixture;

class CategoryCest
{

    public function _fixtures()
    {
        return [
            'categories' => [
                'class' => CategoryFixture::class,
                'dataFile' => __DIR__ . '/../unit/test_fixtures/data/category.php',
                'depends'=>[],
            ],
        ];
    }

    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function checkCategoryLink(FunctionalTester $I, \Helper\Functional $helper)
    {
        $category = $I->grabFixture('categories', 0);
        $helper->goToCategory($I, $category);
        //parse url
        $I->see($category->title, 'h1');
        //$I->see($category->title, ['css'=>'h1',]);
        $I->assertEquals($I->grabTextFrom('#productsPjax h1'), $category->title);
        $I->seeInCurrentUrl($category->title_url);//create url
    }
}
