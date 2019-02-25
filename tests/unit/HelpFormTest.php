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
use page\models\HelpForm;

class HelpFormTest extends \Codeception\Test\Unit
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
        $this->tester->mockRequest();
    }

    protected function _after()
    {
    }

    public function testHelpForm()
    {
        $this->tester->assertTrue(Yii::$app->user->isGuest);

        $model = new HelpForm([
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

        $this->tester->assertCount(1, $emails);
        $this->tester->assertEquals($emails[0]->getSubject(), $model->subject);




    }


}