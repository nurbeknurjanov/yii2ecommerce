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

class ContactFormTest extends \Codeception\Test\Unit
{
    //use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;


    public function _fixtures()
    {
        return [
        ];
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testContactForm()
    {
        $this->tester->assertTrue(Yii::$app->user->isGuest);

        $model = new ContactForm([
            'name'=>'someone',
            'email'=>'some@mail.ru',
            'phone'=>'+996558011477',
            'subject'=>'some subject',
            'body'=>'some text',
        ]);

        if($model->validate())
            $model->sendEmail();
        else
            throw new Exception(Html::errorSummary($model));

        $emails = $this->tester->grabSentEmails();

        $this->tester->assertCount(2, $emails);
        $this->tester->assertEquals($emails[0]->getSubject(), Yii::t('common', 'Thank you for contacting us. We will respond to you as soon as possible.'));
        $this->tester->assertEquals($emails[1]->getSubject(), $model->subject);
    }


}