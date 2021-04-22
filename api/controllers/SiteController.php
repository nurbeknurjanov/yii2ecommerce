<?php

namespace api\controllers;


use common\assets\MenuAsset;
use frontend\models\ContactForm;
use order\assets\OrderAsset;
use order\models\Basket;
use order\models\Order;
use order\models\OrderProduct;
use product\models\Compare;
use themes\sakura\assets\SakuraThemeAsset;
use user\models\SignupForm;
use user\models\User;
use user\models\UserProfile;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\jui\JuiAsset;
use yii\rest\Controller;
use yii\web\JqueryAsset;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;
use yii\filters\Cors;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use yii\web\Response;
use product\models\Product;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => Cors::class,
            ],
        ];
    }

    public function actionTest()
    {

        /*$r = Yii::$app->mailer->compose()
            ->setTo(['nurbek.nurjanov@mail.ru'=>'Nurbek Nurjanov'])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setSubject(Yii::t('common', 'Thank you for contacting us. We will respond to you as soon as possible.'))
            ->setHtmlBody(Yii::t('common', 'Thank you for contacting us. We will respond to you as soon as possible.'))
            ->send();

        return $r;*/
    }
    public function actionRegister()
    {
        $signUp = new SignupForm;
        $signUp->name = Yii::$app->request->post('name');
        $signUp->email = Yii::$app->request->post('email');
        $signUp->password = Yii::$app->request->post('password');
        $signUp->password_repeat = Yii::$app->request->post('password_repeat');
        if($signUp->validate())
            return $user = $signUp->signup();
        return $signUp;
    }

    public function actionIndex()
    {
        $bundle = SakuraThemeAsset::register($this->view);
        $this->view->registerJsFile( Yii::$app->urlManagerApi->createAbsoluteUrl($bundle->baseUrl.'/js/index.js?'.time()));

        $content = $this->renderAjax('/site/index');

        return [
            'content'=>$content,
            /*'promote'=>Product::find()->defaultFrom()->enabled()->promote()->with('mainImage')->limit(8)->all(),
            'popular'=>Product::find()->defaultFrom()->enabled()->popular()->with('mainImage')->limit(12)->all(),
            'novelty'=>Product::find()->defaultFrom()->enabled()->novelty()->with('mainImage')->limit(12)->all(),*/
            'promotes'=>$this->serializeData(Product::find()->defaultFrom()->enabled()->promote()->with('mainImage')->limit(8)->all()),
            'populars'=>$this->serializeData(Product::find()->defaultFrom()->enabled()->popular()->with('mainImage')->limit(12)->all()),
            'novelties'=>$this->serializeData(Product::find()->defaultFrom()->enabled()->novelty()->with('mainImage')->limit(12)->all()),
        ];
    }

    public function actionHeader()
    {
        list ($jsPath, $jsUrl) = $this->view->assetManager->publish((new MenuAsset)->sourcePath.'/menu.js');
        $this->view->registerJsFile( Yii::$app->urlManagerApi->createAbsoluteUrl($jsUrl.'?'.time()));

        list ($jsPath, $jsUrl) = $this->view->assetManager->publish((new SakuraThemeAsset)->sourcePath.'/js/header.js');
        $this->view->registerJsFile( Yii::$app->urlManagerApi->createAbsoluteUrl($jsUrl.'?'.time()));

        return $this->renderAjax('/layouts/header');
    }

    public function actionContact()
    {
        Yii::$app->viewPath = '@frontend/views';
        $model = new ContactForm();

        if(Yii::$app->request->isPost && Yii::$app->request->post('ajax')=='contact-form'){
            Yii::$app->response->off('beforeSend');
            $model->load(Yii::$app->request->post());
            return ActiveForm::validate($model);
        }

        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                $model->sendEmail();
                Yii::$app->session->setFlash('success', Yii::t('common', 'Thank you for contacting us. We will respond to you as soon as possible.'));
            }
            else{
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }
        }

        return [
            'title'=>Yii::t('common', 'Feedback'),
            'content'=>$this->renderAjax('//site/contact', [
                'model' => $model,
            ]),
        ];
    }
} 