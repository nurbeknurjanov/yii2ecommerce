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
use favorite\models\FavoriteLocal;
use favorite\models\Favorite;
use yii\base\Exception;
use comment\models\Comment;
use product\models\Rating;
use yii\test\ActiveFixture;
use yii\web\Request;
use tests\unit\fixtures\CommentFixture;
use tests\unit\fixtures\RatingFixture;
use like\models\Like;

class CommentTest extends \Codeception\Test\Unit
{
    //use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;


    public function _fixtures()
    {
        return [
            'products' => [
                'class' => ProductFixture::class,
                'dataFile' => __DIR__.'/test_fixtures/data/product.php',
                'depends'=>[],
            ],
            'comments' => [
                'class' => CommentFixture::class,
                'dataFile' => __DIR__.'/test_fixtures/data/comment.php',
                'depends'=>[],
            ],
            'ratings' => [
                'class' => RatingFixture::class,
                'dataFile' => __DIR__.'/test_fixtures/data/comment_rating.php',
                'depends'=>[],
            ],
            'likes' => [
                'class' => ActiveFixture::class,
                'tableName'=>Like::tableName(),
                'depends'=>[],
            ],
        ];
    }

    protected function _before()
    {
        $this->tester->mockRequest();
    }

    protected function _after()
    {
    }


    public function testCommentCreate()
    {

        Yii::$app->request->setBodyParams([
            (new Comment)->formName()=>[
                'name'=>'Nick',
                'text'=>'Good computer',
            ],
            (new Rating)->formName()=>[
                'mark'=>4,
            ],
        ]);

        $product = $this->tester->grabFixture('products', 0);


        $model = new Comment(['model_id'=>$product->id, 'model_name'=>$product::className()]);
        $rating = $model->ratingObject;
        $model->load(Yii::$app->request->post());
        $rating->load(Yii::$app->request->post());
        $model->save();

        $this->tester->seeRecord(Comment::class, ['id'=>$model->id]);
        $this->tester->seeRecord(Rating::class, ['id'=>$rating->id]);

        $product->refresh();

        $this->tester->assertEquals($product->rating, 4.5);

        $this->tester->assertEquals($product->rating_count, 2);


        $like = new Like(['model_id'=>$model->id, 'model_name'=>$model::className()]);
        $like->load(['mark'=>1], '');
        $like->save();

        $this->tester->seeRecord(Like::class, ['id'=>$like->id]);
        $product->refresh();
        $this->tester->assertEquals(round($product->rating, 2), 4.33);

        $like->mark = -1;
        $like->save();
        $product->refresh();
        $this->tester->assertEquals($product->rating, 5);

        $like2 = new Like(['model_id'=>$model->id, 'model_name'=>$model::className()]);
        $like2->load(['mark'=>-1], '');
        $like2->save();

        $product->refresh();
        $this->tester->assertEquals($product->rating, 5);


        $like->delete();
        $like2->delete();
        $product->refresh();
        $this->tester->assertEquals($product->rating, 4.5);

    }
}