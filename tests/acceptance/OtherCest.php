<?php

use yii\helpers\Url;
use tests\unit\fixtures\UserFixture;
use tests\unit\fixtures\UserProfileFixture;
use user\models\Token;
use yii\test\ActiveFixture;
use user\models\LoginForm;
use user\models\User;
use user\models\PasswordResetRequestForm;
use user\models\ResetPasswordForm;
use user\models\SignupForm;
use tests\unit\fixtures\CategoryFixture;
use console\controllers\RbacInitController;

class OtherCest
{
    public function _fixtures()
    {
        return [
            'categories' => [
                'class' => CategoryFixture::class,
                'depends'=>[],
            ],

        ];
    }

    public function _before(AcceptanceTester $I)
    {
        if(in_array($I->getScenario()->getFeature(),['check language of user','edit profile language']))
            $I->haveFixtures([
                'users' => [
                    'class' => UserFixture::class,
                    'forceUpdateRBAC'=>true,
                    'depends'=>[],
                ],
                'user_profiles' => [
                    'class' => UserProfileFixture::class,
                    'depends'=>[],
                    'dataFile'=>null,
                ],
            ]);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /* public function checkLanguageOfUser(AcceptanceTester $I)
    {
        $I->updateInDatabase('user', ['language'=>'ru']);
        $I->amOnPage(Url::to(['/user/user/list']));
        $I->waitForText('Login');
        $I->login($I, 'admin',123123, false);
        Yii::$app->language='ru';
        $I->waitForText('Пользователи', null,'h1');
        $I->logout($I);


        $I->updateInDatabase('user', ['language'=>'en-US']);
        $I->amOnPage(Url::to(['/user/user/list']));
        $I->waitForText('Вход');
        $I->login($I, 'admin',123123, false);

        Yii::$app->language='en-US';
        $I->waitForText('Users', null, 'h1');
        $I->logout($I);
    } */


    private function editProfileLanguage(AcceptanceTester $I, \Helper\Acceptance $helper)
    {
        $I->login($I);
        $user = $I->grabFixture('users', 0);
        $I->openMenu($I);
        $I->click(Yii::t('user', 'Edit profile'));
        $I->see(Yii::t('user', 'Edit profile'), 'h1');

        $I->selectOption($user->formName().'[language]', 'ru');
        $I->click(Yii::t('common', 'Save'));
        $I->waitForElement('.alert-success');

        $I->reloadPage();
        Yii::$app->language = 'ru';
        $I->see(Yii::t('user', 'Edit profile'), 'h1');

        $I->selectOption($user->formName().'[language]', 'en-US');
        $I->click(Yii::t('common', 'Save'));
        $I->waitForElement('.alert-success');
        $I->reloadPage();
        Yii::$app->language = 'en-US';
        $I->see(Yii::t('user', 'Edit profile'), 'h1');
    }

    public function checkLanguageOfSite(AcceptanceTester $I)
    {
        $category = $I->grabFixture('categories', 0);
        $I->goToCategory($I, $category);
        $this->checkPageIsTheSame($I);

        $I->seeLink('English');
        $I->moveMouseOver( '.navbar-top .navbar-right > li:nth-last-child(2) > a' );
        $I->click('Русский');
        Yii::$app->language='ru';
        $this->checkPageIsTheSame($I);

        $I->seeLink('Русский');
        $I->moveMouseOver( '.navbar-top .navbar-right > li:nth-last-child(2) > a' );
        $I->click('English');
        Yii::$app->language='en-US';
        $this->checkPageIsTheSame($I);
    }
    public function checkTheme(AcceptanceTester $I)
    {
        $category = $I->grabFixture('categories', 0);
        $I->goToCategory($I, $category);
        $this->checkPageIsTheSame($I);

        //$I->click(Yii::t('common', 'Theme'));
        $I->moveMouseOver( '.navbar-top .navbar-right > li:last-child > a' );
        $I->click('Sakura Light');
        $this->checkPageIsTheSame($I);

        $I->moveMouseOver( '.navbar-top .navbar-right > li:last-child > a' );
        $I->click('Bootstrap');
        $this->checkPageIsTheSame($I);

        $I->moveMouseOver( '.navbar-fixed-top .navbar-right > li:last-child > a' );
        //$I->clickWithLeftButton( '.navbar-fixed-top .navbar-right > li:last-child > a' );
        $I->click('Sakura');
        //$this->checkPageIsTheSame($I);
    }

    protected function checkPageIsTheSame(AcceptanceTester $I)
    {
        $category = $I->grabFixture('categories', 0);
        $I->see($category->t('title'));
        //$I->see($category->title, 'h1.categoryTitle');
        //$I->assertEquals($I->grabTextFrom('#productsPjax h1'), $category->title);
        $I->seeInCurrentUrl($category->title_url);//create url
    }
}
