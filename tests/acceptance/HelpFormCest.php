<?php

use page\models\HelpForm;
use user\models\User;
use yii\helpers\Html;
use eav\models\DynamicField;
use tests\unit\fixtures\CategoryFixture;
use extended\helpers\Helper;
use product\models\Product;
use tests\unit\fixtures\DynamicFieldFixture;
use tests\unit\fixtures\DynamicValueFixture;
use eav\models\DynamicValue;
use product\models\search\ProductSearchFrontend;
use tests\unit\fixtures\ProductFixture;
use order\models\Basket;
use order\models\OrderProduct;
use order\models\Order;
use order\models\OrderLocal;
use yii\web\Request;
use frontend\models\ContactForm;
use yii\base\Exception;
use yii\helpers\Url;


class HelpFormCest
{

    public function _before(AcceptanceTester $I)
    {
        $I->clearEmails();
    }

    public function _after(AcceptanceTester $I)
    {
    }


    public function checkHelpForm(AcceptanceTester $I)
    {

        $I->amOnPage(Url::to(Yii::$app->homeUrl));

        $I->seeLink('Help');
        $I->click('Help');

        $form = new HelpForm;
        $I->see($form->getAttributeLabel('name'));
        $I->fillField($form->formName()."[name]", 'someone');
        $I->fillField($form->formName()."[email]", 'some@mail.ru');
        $I->fillField($form->formName()."[phone]", '+996558011477');
        $I->fillField($form->formName()."[body]", 'some text');
        $I->click('#help-form button');
        $I->waitForElement('.alert-success');


        $emails = $I->getEmails();
        $I->assertCount(1, $emails);
        $url = '/assets/mails/'.$emails[0];
        $I->amOnPage($url);
        $I->see(Yii::t('page', 'You have requested for help.'));
    }
}
