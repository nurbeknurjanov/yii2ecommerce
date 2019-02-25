<?php


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

class ContactFormCest
{

    public function _before(AcceptanceTester $I)
    {
        $I->clearEmails();
    }

    public function _after(AcceptanceTester $I)
    {
    }


    public function checkContactForm(AcceptanceTester $I)
    {

        $I->amOnPage(Url::to(Yii::$app->homeUrl));
        $I->seeLink('Feedback');
        $I->click('Feedback');
        $form = new ContactForm;
        $I->see($form->getAttributeLabel('name'));
        $I->fillField($form->formName()."[name]", 'someone');
        $I->fillField($form->formName()."[email]", 'some@mail.ru');
        $I->fillField($form->formName()."[phone]", '+996558011477');
        $I->fillField($form->formName()."[subject]", 'some subject');
        $I->fillField($form->formName()."[body]", 'some text');
        $I->click('.form-group button');
        $I->waitForElement('.alert-success');

        $I->wait(2);
        $emails = $I->getEmails();
        $I->assertCount(2, $emails);
        /*Yii::$app->urlManager->baseUrl='/frontend/web/';
         Yii::$app->urlManager->showScriptName=false;
         $url = Yii::$app->urlManager->createAbsoluteUrl('/assets/mails/'.$email_file);*/
        $url = '/assets/mails/'.$emails[0];
        $I->amOnPage($url);
        $I->see(Yii::t('common', 'Thank you for contacting us. We will respond to you as soon as possible.'));

        $url = '/assets/mails/'.$emails[1];
        $I->amOnPage($url);
        $I->see('some subject');

    }
}
