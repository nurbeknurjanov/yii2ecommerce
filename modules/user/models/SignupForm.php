<?php
namespace user\models;

use user\models\create\TokenCreate;
use user\models\create\UserCreate;
use yii\base\Exception;
use yii\base\Model;
use Yii;
use yii\helpers\Html;
use yii\web\JsExpression;
use \himiklab\yii2\recaptcha\ReCaptchaValidator;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $name;
    public $email;
    public $password;
    public $password_repeat;

    public $reCaptcha;
    public $accept_terms;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            //['username', 'required'],
            ['username', 'unique', 'targetClass' => '\user\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['name', 'required'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\user\models\User', 'message'=>Yii::t('yii', '{attribute} "{value}" has already been taken.')],

            [['password', 'password_repeat'], 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute'=>'password'],


            [['reCaptcha'], ReCaptchaValidator::className(),
                'when'=>function($model){
                    return YII_ENV_PROD && !Yii::$app->request->isAjax;
                },
                'on'=>'step1',
            ],

            ['accept_terms', 'boolean'],
            [
                'accept_terms', 'required', 'requiredValue' => 1,
                'message' => Yii::t('common', 'You must agree to the terms and conditions'),
                'on'=>'step2',
            ]
        ];
    }

    /**
     * Signs user up.
     *
     * @return \user\models\User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($user = UserCreate::createUserInactive(['username'=>$this->username, 'email'=>$this->email, 'name'=>$this->name, 'password'=>$this->password])) {
            $user->sendActivateToken();
            return $user;
        }else
            throw new Exception(strip_tags(Html::errorSummary($user, ['header'=>false,])));
    }

    public function attributeLabels()
    {
        return [
            'email'=>Yii::t('common', 'Email'),
            'name'=>Yii::t('common', 'Name'),
            'password'=>Yii::t('user', 'Password'),
            'password_repeat'=>Yii::t('user', 'Repeat password'),
            'accept_terms'=>Yii::t('user', 'Accept terms'),
        ];
    }

}
