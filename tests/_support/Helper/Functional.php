<?php
namespace Helper;

use category\models\Category;
use FunctionalTester;
use Yii;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Functional extends \Codeception\Module
{
    public function goToCategory(FunctionalTester $I, Category $category)
    {
        $I->amOnPage(Yii::$app->homeUrl);
        $I->seeLink($category->title);
        $I->click($category->title);
    }

}
