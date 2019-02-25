<?php

use yii\helpers\Url;
use tests\unit\fixtures\UserFixture;
use user\models\Token;
use yii\test\ActiveFixture;
use user\models\LoginForm;
use user\models\User;
use tests\unit\fixtures\CategoryFixture;
use tests\unit\fixtures\PageFixture;

class PageCest
{

    public function _fixtures()
    {
        return [
            'pages' => [
                'class' => PageFixture::class,
                'depends'=>[],
            ],
        ];
    }

    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function checkPageLink(AcceptanceTester $I)
    {
        $page = $I->grabFixture('pages', 0);
        $I->amOnPage(Url::to(Yii::$app->homeUrl));
        $I->see($page->title);
        $I->click($page->title);
        //parse url
        $I->waitForText($page->title);
        $I->seeInCurrentUrl($page->url);
    }
}
