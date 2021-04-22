<?php

use yii\helpers\Url;
use user\models\Token;
use yii\test\ActiveFixture;
use user\models\LoginForm;
use user\models\User;
use tests\unit\fixtures\CategoryFixture;
use tests\unit\fixtures\DynamicFieldFixture;

class DynamicFieldCest
{

    public function _fixtures()
    {
        return [
            'categories' => [
                'class' => CategoryFixture::class,
                'dataFile' => __DIR__ . '/../unit/test_fixtures/data/category.php',
                'depends'=>[],
            ],
            'dynamic_fields'=>[
                'class'=>DynamicFieldFixture::class,
                'depends'=>[],
                'dataFile' => __DIR__ . '/../unit/test_fixtures/data/dynamic_field.php'
            ],
        ];
    }

    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function checkDynamicFieldsAppears(AcceptanceTester $I)
    {
        /* @var $proccesor \eav\models\DynamicField */
        $proccesor = $I->grabFixture('dynamic_fields', 0);
        $brand = $I->grabFixture('dynamic_fields', 1);
        $I->amOnPage(Url::to(['/product/product/list']));
        $I->dontSee($proccesor->label);
        $I->see($brand->label);

        $I->goToCategory($I,$I->grabFixture('categories', 0));
        $I->waitForText($proccesor->label);
        $I->see($brand->label);

        $I->goToCategory($I,$I->grabFixture('categories', 1));
        $I->dontSee($proccesor->label);
        $I->see($brand->label);
        //$I->see($category->title, ['css'=>'h1',]);
    }
}
