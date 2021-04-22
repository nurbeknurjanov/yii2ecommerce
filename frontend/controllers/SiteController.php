<?php
namespace frontend\controllers;

use article\models\search\ArticleSearch;
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
use yii\base\Model;
use yii\data\ActiveDataFilter;
use yii\data\DataFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\validators\NumberValidator;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\ContactForm;
use yii\web\Request;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\web\View;
use yii\httpclient\Client;
use yii\filters\Cors;
use yii\rest\Controller as RestController;
use \extended\controller\Controller;
use yii\widgets\ActiveForm;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['test'],
                'rules' => [
                    [
                        'actions' => ['test', 'test2', 'test-api'],
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
        /*Yii::$app->session->setFlash('success', 'Nurbek');
        return 123;*/
        /*Yii::$app->response->cookies->add(new Cookie([
            'name' => 'talafo',
            'value' => 'nurjanov',
            'expire' => time() + 3600*24*7,
        ]));
        return $this->redirect(['/site/test']);*///пашет

        return $this->render('index');
    }

    public function actionTestApi()
    {
        /*Yii::$app->response->format = Response::FORMAT_JSON;
        $page = Page::find()->one();
        return [
            'page'=>['title'=>$page->title, 'text'=>$page->text]
        ];*/
    }
    public function actionTest2()
    {
        return 'test2';
    }
    public function actionTest()
    {
        //header("Location: http://demo.sakura.com/site/test2");

        //Yii::$app->response->getHeaders()->set('X-PJAX-Url',Url::to(['site/test2']));

        //return $this->run(Url::to(['site/test2']));

        //return Yii::$app->response->redirect('https://mail.ru', 301, false);//wont work, cuz mail.ru has no cors
        return Yii::$app->response->redirect(Url::to(['site/test2']), 301, false);//works
        return $this->renderContent('test');
        //return 'test';
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
