<?php

use user\models\create\TokenCreate;
use user\models\User;
use yii\helpers\Html;
use eav\models\DynamicField;
use tests\unit\fixtures\CategoryFixture;
use extended\helpers\Helper;
use tests\unit\fixtures\UserFixture;
use tests\unit\fixtures\UserProfileFixture;
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
use user\models\LoginForm;
use yii\web\Cookie;
use user\models\SignupForm;
use cebe\gravatar\Gravatar;
use yii\web\UploadedFile;
use file\models\File;
use yii\test\ActiveFixture;
use user\models\Token;
use user\models\ResetPasswordForm;
use user\models\PasswordResetRequestForm;

class UserTest extends \Codeception\Test\Unit
{
    //use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;


    public function _fixtures()
    {
        return [
            'users' => [
                'class' => UserFixture::class,
                'depends'=>[],
            ],
             'user_profiles' => [
                'class' => UserProfileFixture::class,
                'depends'=>[],
            ],
            'tokens' => [
                'class' => ActiveFixture::class,
                'tableName'=>Token::tableName(),
                'depends'=>[],
            ],
        ];
    }

    protected function _before()
    {
        Yii::$app->mailer->viewPath = '@user/mail';
    }

    protected function _after()
    {
    }

    public function testLogin()
    {
        $this->tester->assertTrue(Yii::$app->user->isGuest);
        $model = new LoginForm(['username'=>'admin', 'password'=>'123123']);
        $model->login();
        $this->tester->assertFalse(Yii::$app->user->isGuest);
    }

    public function testSignUp2()
    {
        $referrer = $this->tester->grabFixture('users', 0);
        $_SESSION = $this->testSignUp();
        Yii::$app->request->setBodyParams([
            (new SignupForm)->formName()=>[
                'accept_terms'=>1,
            ]
        ]);

        $model = new SignupForm();
        $model->scenario = 'step2';
        if (isset($_SESSION['SignupForm']))
            $model->attributes = $_SESSION['SignupForm'];
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = $model->signup();

            /*$gravatar = new Gravatar([
                'email' => $user->email,
                'defaultImage' => 404,
            ]);
            if (!preg_match("/404 Not Found/i", get_headers($gravatar->imageUrl)[0])) {
                $user->imageAttribute = new UploadedFile();
                $user->imageAttribute->name = "from gravatar.jpg";
                $user->imageAttribute->tempName = (new File())->copy($gravatar->imageUrl);
                $user->save(false);
            }*/
            $this->tester->seeRecord(User::class, ['id'=>$user->id]);
            $this->tester->assertEquals(User::STATUS_INACTIVE, $user->status);

            $this->tester->seeRecord(Token::class);

            $token = $this->tester->grabRecord(Token::class);
            $token->run();
            $user->refresh();
            $this->tester->assertEquals(User::STATUS_ACTIVE, $user->status);
            //$this->tester->assertEquals($referrer->email, $user->from);
            //$this->tester->assertEquals($referrer->id, $user->referrer_id);


        }else
            throw new Exception(Html::errorSummary($model));
    }
    public function testSignUp()
    {
        $referrer = $this->tester->grabFixture('users', 0);

        //Yii::$app->session->set('referrer_id', $referrer->id);
        Yii::$app->request->setQueryParams([
            'from'=>$referrer->email,
        ]);

        Yii::$app->request->setBodyParams([
            (new SignupForm)->formName()=>[
                'name'=>'some name',
                'email'=>'someemail@mail.ru',
                'password'=>'some pass',
                'password_repeat'=>'some pass',
            ]
        ]);

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


        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            foreach (Yii::$app->request->post('SignupForm') as $attribute=>$value)
                $_SESSION['SignupForm'][$attribute]=$value;
        }else
            throw new Exception(Html::errorSummary($model));

        return $_SESSION;
    }

    public function testResetPassword()
    {
        $user = $this->tester->grabFixture('users', 0);

        $model = new PasswordResetRequestForm();

        Yii::$app->request->setBodyParams([
            $model->formName()=>[
                'email'=>$user->email,
            ]
        ]);

        $model->load(Yii::$app->request->post());
        $this->tester->assertTrue($model->validate());



        $this->tester->assertTrue($model->sendEmail());

        $this->tester->seeRecord(Token::class);

        $emails = $this->tester->grabSentEmails();
        $this->tester->assertCount(1, $emails);

        $token = $this->tester->grabRecord(Token::class);
        Yii::$app->request->setQueryParams([
            'token'=>$token->token
        ]);

        $modelReset = new ResetPasswordForm($token->token);

        Yii::$app->request->setBodyParams([
            $modelReset->formName()=>[
                'password'=>'password',
                'password_repeat'=>'password',
            ]
        ]);
        $modelReset->load(Yii::$app->request->post());
        if(!$modelReset->validate())
            throw  new Exception(Html::errorSummary($modelReset));

        $this->tester->assertTrue($modelReset->resetPassword());

        $emails = $this->tester->grabSentEmails();
        $this->tester->assertCount(2, $emails);
    }


    public function testEditProfile()
    {
        Yii::$app->user->setIdentity(User::find()->one());
        $model = Yii::$app->user->identity;

        Yii::$app->request->setBodyParams([
            $model->formName()=>[
                'name'=>'another name',
            ]
        ]);
        $model->load(Yii::$app->request->post());
        $model->save();
        $model->refresh();
        $this->tester->assertEquals($model->name, 'another name');
    }

    public function testChangeEmail()
    {
        $user = User::find()->one();
        Yii::$app->user->setIdentity($user);
        $user = Yii::$app->user->identity;

        $user->scenario = 'changeEmail';

        Yii::$app->request->setBodyParams([
            $user->formName()=>[
                'email_new'=>'anotheremail@mail.ru',
                'password'=>'123123',
            ]
        ]);

        $user->load(Yii::$app->request->post());
        if ($user->validate(['email_new', 'password'])){
            $token = TokenCreate::create(Token::ACTION_CHANGE_EMAIL, $user, $user->email_new);
            $token->run();
            $user->refresh();
            $this->tester->assertEquals($user->email, 'anotheremail@mail.ru');
        }else
            throw new Exception(Html::errorSummary($user));

    }

    public function testChangePassword()
    {
        $user = User::find()->one();
        Yii::$app->user->setIdentity($user);


        $model = Yii::$app->user->identity;
        $model->scenario = 'changePassword';

        Yii::$app->request->setBodyParams([
            $model->formName()=>[
                'password'=>'123123',
                'password_new'=>'321321',
                'password_new_repeat'=>'321321',
            ]
        ]);


        $model->load(Yii::$app->request->post());
        if ($model->validate(['password', 'password_new', 'password_new_repeat'])){
            $model->setPassword($model->password_new);
            $model->save(false);

            $loginForm = new LoginForm(['username'=>'admin', 'password'=>'123123']);
            $this->tester->assertFalse($loginForm->validate());

            $loginForm = new LoginForm(['username'=>'admin', 'password'=>'321321']);
            $this->tester->assertTrue($loginForm->validate());

        }else
            throw new Exception(Html::errorSummary($model));
    }

    public function testSetPassword()
    {
        $user = User::find()->one();
        Yii::$app->user->setIdentity($user);


        $model = Yii::$app->user->identity;
        $model->scenario='setPassword';

        Yii::$app->request->setBodyParams([
            $model->formName()=>[
                'password_set'=>'321321',
                'password_set_repeat'=>'321321',
            ]
        ]);

        $model->load(Yii::$app->request->post());

        if($model->validate(['password_set', 'password_set_repeat'])){
            $model->setPassword($model->password_set);
            $model->save(false);

            $loginForm = new LoginForm(['username'=>'admin', 'password'=>'321321']);
            $this->tester->assertTrue($loginForm->validate());
        }else
            throw new Exception(Html::errorSummary($model));

    }
}