<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace user\controllers;



use cebe\gravatar\Gravatar;
use extended\controller\Controller;
use file\models\File;
use user\models\create\TokenCreate;
use user\models\create\UserCreate;
use user\models\LoginForm;
use user\models\PasswordResetRequestForm;
use user\models\ResetPasswordForm;
use user\models\User;
use frontend\models\User as UserFrontend;
use Yii;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\helpers\Url;
use user\models\SignupForm;
use user\models\Token;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

class GuestController extends Controller
{
    public function actions()
    {
        //$route=Yii::$app->requestedRoute;
        //$route=explode('/',$route);
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    public function successCallback($client)
    {
        if(!Yii::$app->request->get('authclient'))
            throw new Exception("authclient is missing");
        $attributes=UserFrontend::customizeAttributes($client->getUserAttributes(), Yii::$app->request->get('authclient'));

        if(!isset($attributes['email']) || !$attributes['email'])
            throw new Exception("Email is missing");

        if(!(   $user=User::findOne(['email'=>$attributes['email']])   )){
            $name='';
            if(isset($attributes['first_name']))
                $name.= $attributes['first_name'];
            if(isset($attributes['last_name']))
                $name.= ' '.$attributes['last_name'];
            $name = trim($name);
            $user = UserCreate::createUserInactiveForce(['email'=>$attributes['email'], 'name'=>$name]);
            $user->activateStatus();
        }




        if($attributes['photo'] && Yii::$app->request->get('authclient')!='facebook'){
            if($user->image)
                $user->image->delete();
            $user->imageAttribute = new UploadedFile();
            $user->imageAttribute->name = $attributes['photo'];
            $user->imageAttribute->tempName =  (new File())->copy($attributes['photo']) ;
            $user->save(false);
        }
        if(!$user->id)
            throw new Exception(strip_tags(Html::errorSummary($user, ['header'=>false,])));

        Yii::$app->user->login($user, 3600 * 24 * 30);

        if(isset(Yii::$app->user->identity->language) && Yii::$app->user->identity->language){
            return $this->goBackWithLanguage();
        }
        return $this->goBack();
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'auth'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [ 'unsubscribe'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action)
                        {
                            return in_array(Yii::$app->id, ['app-frontend', 'app-frontend-test']);
                        }
                    ],
                    [
                        'actions' => ['signup', 'signup2','request-password-reset', 'reset-password', 'resend-activate-link'],
                        'allow' => true,
                        'roles' => ['?'],
                        'matchCallback' => function($rule, $action)
                            {
                                return in_array(Yii::$app->id, ['app-frontend', 'app-frontend-test']);
                            }
                    ],
                ],
            ],
        ];
    }
    public function actionUnsubscribe($token)
    {
        $email = Yii::$app->security->decryptByKey($token, 'email');
        $user = User::findByUsernameOrEmail($email);
        if(!$user)
            throw new NotFoundHttpException();
        $user->updateAttributes(['subscribe'=>-1]);
        Yii::$app->session->setFlash("success", Yii::t('user', 'You have successfully canceled the subscription.'));
        return $this->goAlert();
    }

    public function actionSignup()
    {
        if(Yii::$app->request->get('from')){
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'from',
                'value' => Yii::$app->request->get('from'),
                'expire' => time() + 3600*24,
            ]));
        }
        $model = new SignupForm();
        $model->scenario='step1';
        if(isset($_SESSION['SignupForm']))
            $model->attributes = $_SESSION['SignupForm'];
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            foreach ($_POST['SignupForm'] as $attribute=>$value)
                $_SESSION['SignupForm'][$attribute]=$value;
            return $this->redirect(['signup2']);
        }
        return $this->render('signup/step1', [
            'model' => $model,
        ]);
    }

    public function actionSignup2()
    {
        $model = new SignupForm();
        $model->scenario='step2';
        if(isset($_SESSION['SignupForm']))
            $model->attributes = $_SESSION['SignupForm'];
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $user = $model->signup();

            /*$gravatar = new Gravatar([
                'email' => $user->email,
                'defaultImage'=>404,
            ]);
            if (!preg_match("/404 Not Found/i", get_headers($gravatar->imageUrl)[0])){
                $user->imageAttribute = new UploadedFile();
                $user->imageAttribute->name = "from gravatar.jpg";
                $user->imageAttribute->tempName = (new File())->copy($gravatar->imageUrl);
                $user->save(false);
            }*/

            unset($_SESSION['SignupForm']);
            Yii::$app->session->setFlash('success', Yii::t('user', 'Thank you for signing up. We have sent to your email a link to activate your account.'));
            return $this->goAlert();
        }
        return $this->render('signup/step2', [
            'model' => $model,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function goBackWithLanguage()
    {
        //return url and language
        $request = new Request();
        $request->baseUrl = Yii::$app->request->baseUrl;
        $request->scriptUrl = Yii::$app->request->scriptUrl;
        //$request->url = "/ru/electronics/computers?qwe=asd";
        //$request->url = "/ru/product/product/view?id=5";
        $request->url = Yii::$app->getUser()->getReturnUrl(null);


        $route = $request->resolve()[0];
        $route = trim($route, "/");
        $route = preg_replace('/^('.Yii::$app->language.'|mouse)|inend$/', '', $route);
        $route = trim($route, "/");
        $request->pathInfo = $route;

        $parse = parse_url($request->url);
        if(isset($parse['query']))
            parse_str($parse['query'], $getParams);
        else
            $getParams=[];
        $params = array_merge($request->resolve()[1], $getParams);

        $params['language'] = Yii::$app->user->identity->language;
        unset($params['code']);
        unset($params['state']);
        if(Yii::$app->request->get('authclient'))
            return $this->action->redirect( Url::to(['/'.$route] + $params) );
        return Yii::$app->response->redirect(Url::to(['/'.$route] + $params));
    }


    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->login())
        {
            if(isset(Yii::$app->user->identity->language) && Yii::$app->user->identity->language){
                return $this->goBackWithLanguage();
            }
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }


    public function actionResendActivateLink($username)
    {
        $user = User::findByUsernameOrEmail($username);
        if(!$user)
            throw new InvalidArgumentException('The username is invalid.');
        $user->sendActivateToken();
        Yii::$app->session->setFlash('success', Yii::t('user', 'We have sent to your email a link to activate your account.'));
        return $this->goAlert();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()){
                Yii::$app->session->setFlash('success', Yii::t('user', 'Check your email for further instructions.'));
                return $this->refresh();
            }
            else
                Yii::$app->session->setFlash('error', Yii::t('user', 'Sorry, we are unable to reset password for email provided.'));
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()){
            Yii::$app->session->setFlash('success', Yii::t('user', 'You successfully set new password.'));
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
} 