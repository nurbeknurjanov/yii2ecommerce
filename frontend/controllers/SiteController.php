<?php
namespace frontend\controllers;

use comment\models\Comment;
use file\models\File;
use Imagine\Image\ImageInterface;
use like\models\Like;
use order\models\Order;
use order\models\OrderProduct;
use page\models\Page;
use product\models\Rating;
use user\models\User;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\ContactForm;
use yii\web\Cookie;
use yii\web\Request;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\web\View;
use yii\httpclient\Client;

/*
class Bar
{
    public $title = 'bar';
}

class Foo
{
    public $bar;
    public function __construct(Bar $bar)
    {
        $this->bar = $bar;
    }
    public function pr()
    {
        echo $this->bar->title;
    }
}


$bar = new Bar;
$foo = new Foo($bar);
$foo->pr();

$container = Yii::$container;
*/
//$container->set('foo', 'Foo');

//$foo = Yii::$container->get('\frontend\controllers\Foo');
//$foo->pr();

/*$myBar = new Bar();
$myBar->title = 'my title';*/
//$foo = Yii::$container->get('\frontend\controllers\Foo', [$myBar]);
/*$foo = Yii::$container->get('\frontend\controllers\Foo', [], [
    'bar'=>$myBar,
]);*/

/*Yii::$container->set('frontend\controllers\Bar', [
    'class'=>'\frontend\controllers\Bar',
    'title'=>'123123123',
]);*/

/*Yii::$container->set('myFoo', [
    'class'=>'\frontend\controllers\Foo',
    //'bar'=>$myBar,
], ['0'=>$myBar]);
$foo = Yii::$container->get('myFoo');
$foo->pr();*/



/*$foo = Yii::$app->get('foo');
$foo->pr();*/

/**
 * Site controller
 */
class SiteController extends \extended\controller\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['test'],
                'rules' => [
                    [
                        'actions' => ['test', 'test-api'],
                        'allow' => true,
                        //'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'some' => ['post'],
                ],
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'page' => [
                'class' => 'yii\web\ViewAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        /*Yii::$app->response->cookies->add(new Cookie([
            'name' => 'talafo',
            'value' => 'nurjanov',
            'expire' => time() + 3600*24*7,
        ]));
        return $this->redirect(['/site/test']);*///пашет
        return $this->render('index');
    }


    //public $enableCsrfValidation = false;
    public function actionTestApi()
    {
        /*Yii::$app->response->format = Response::FORMAT_JSON;
        $page = Page::find()->one();
        return [
            'page'=>['title'=>$page->title, 'text'=>$page->text]
        ];*/
    }
    public function actionTest()
    {
        return 'test';
        //echo Yii::$app->request->cookies->get('malafo')->value;
        /*OrderProduct::deleteAll("1=1");
        Order::deleteAll("1=1");
        User::deleteAll("id>1");*/
    }



    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('common', 'Thank you for contacting us. We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

}
