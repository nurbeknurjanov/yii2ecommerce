<?php

use yii\helpers\Url;

class ExampleFunctionalCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->amOnPage(Yii::$app->homeUrl);
        $I->see(Yii::t('common', 'Ecommerce platform based on Yii2 PHP Framework'));
    }
}
