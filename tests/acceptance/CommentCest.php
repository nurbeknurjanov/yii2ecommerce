<?php

namespace tests\acceptance;

use Facebook\WebDriver\WebDriverElement;
use Facebook\WebDriver\WebDriverBy;
use yii\helpers\Url;
use tests\unit\fixtures\ProductFixture;
use tests\unit\fixtures\CategoryFixture;
use order\models\OrderProduct;
use order\models\Order;
use product\models\Product;
use Yii;
use AcceptanceTester;
use yii\helpers\Html;
use product\models\Compare;
use comment\models\Comment;
use tests\unit\fixtures\CommentFixture;
use tests\unit\fixtures\RatingFixture;
use like\models\Like;
use yii\test\ActiveFixture;
use tests\unit\fixtures\FileFixture;

class CommentCest
{
    public function _fixtures()
    {
        return [
            'categories' => [
                'class' => CategoryFixture::class,
                'dataFile' => __DIR__ . '/../unit/test_fixtures/data/category.php',
                'depends'=>[],
            ],
            'products' => [
                'class' => ProductFixture::class,
                'dataFile' => __DIR__ . '/../unit/test_fixtures/data/product.php',
                'depends'=>[],
            ],
            'comments' => [
                'class' => CommentFixture::class,
                'dataFile' => __DIR__.'/../unit/test_fixtures/data/comment.php',
                'depends'=>[],
            ],
            'ratings' => [
                'class' => RatingFixture::class,
                'dataFile' => __DIR__.'/../unit/test_fixtures/data/comment_rating.php',
                'depends'=>[],
            ],
            'files' => [
                'class' => FileFixture::class,
                'depends'=>[],
                'dataFile'=>false,
            ],
            'likes' => [
                'class' => ActiveFixture::class,
                'tableName'=>Like::tableName(),
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


    public function testAddComment(AcceptanceTester $I)
    {
        $product = $I->grabFixture('products', 0);

        $I->goToProduct($I, $product);

        $I->see('Adam Smith');
        $I->see('One of the best laptop values around');

        $I->waitForElement('.product-view-rating .filled-stars[style="width: 100%;"]');


        $I->seeElement('[href="#comments"]');
        $I->click('[href="#comments"]');
        $I->waitForText('Leave a comment');

        $form = new Comment;
        $I->see($form->getAttributeLabel('name'));
        $I->fillField($form->formName()."[name]", 'Nick Carter');
        $I->wait(1);
        $I->click('form span.star:nth-child(4)');
        $I->wait(1);
        $I->fillField($form->formName()."[text]", 'Good computer');
        //$I->fillField($form->formName()."[videoAttribute]", 'https://www.youtube.com/watch?v=9SGIDn52MaA');
        //$I->attachFile(['name'=>'Comment[imagesAttribute][]',], 'computer.jpg');
        $I->click(Yii::t('comment', 'Submit a comment'));
        $I->waitForText(Yii::t('comment', 'Review successfully leaved.'));

        $I->waitForElement('.product-view-rating .filled-stars[style="width: 90%;"]');

        $I->waitForText('Good computer');
        $I->see(2, '#commentCountPjax');



        $I->click('.hoverGreen[data-model_id="2"]');

        $I->waitForElement('.product-view-rating .filled-stars[style="width: 86.6666%;"]');
        //->click("[data-notify='container'] button.close")
        //->waitForElementNotVisible("[data-notify='container']")



        //$I->click('.hoverRed[data-model_id="2"]');
        //$I->waitForElement('.product-view-rating .filled-stars[style="width: 100%;"]');


        $I->waitForElement('.glyphicon-trash');
        $I->clickWithLeftButton('.glyphicon-trash', 0,0);
        //$I->clickWithRightButton('.glyphicon-trash', 0,89);
        //$I->clickWithLeftButton('.glyphicon-trash', 0,89);
        //if bootbox appears, then question must be allready there without waiting!!! weird little bit.
        $I->performOn('.bootbox',
            \Codeception\Util\ActionSequence::build()
                ->waitForText('Are you sure you want to delete this item?')
                ->click(Yii::t('common', 'CONFIRM'))
        );
        /*$I->performOn('.rememberMe', function (WebDriver $I) {
            $I->see('Remember me next time');
            $I->seeElement('#LoginForm_rememberMe');
            $I->dontSee('Login');
        });*/
        /*$I->waitForElementVisible('.bootbox');
        $I->waitForText('Are you sure you want to delete this item?');
        $I->click(Yii::t('common', 'CONFIRM'));
        $I->waitForElementNotVisible('.bootbox');*/

        $I->waitForElement('.product-view-rating .filled-stars[style="width: 100%;"]');
        $I->dontSee('Good computer');
        $I->see(1, '#commentCountPjax');
    }

}
