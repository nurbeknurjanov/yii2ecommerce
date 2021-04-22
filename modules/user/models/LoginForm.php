<?php
namespace user\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    //public $validateAttribute=1;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            //['validateAttribute', 'validateIP'],
            ['password', 'validatePassword'],
            ['username', 'validateStatus'],
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                return $this->addError($attribute, 'Incorrect username or password.');
            }
            if(Yii::$app->id=='app-backend'){
                if(!Yii::$app->authManager->checkAccess($user->id, User::ROLE_MANAGER)){
                    $this->addError($attribute, 'Incorrect username or password.');
                }
            }
        }
    }
    public function validateStatus($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if($user){
                if(!$user->isActive)
                    $this->addError($attribute, 'Verify your email. '
                        .Html::a('Resend Activation Link', ['/user/guest/resend-activate-link', 'username'=>$this->username]));
            }
        }
    }


    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $result = Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
            return $result;
        } else {
            Yii::info("Login failed for user '{$this->username}' with password '{$this->password}'", 'loginFailed');
            return false;
        }
    }


    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsernameOrEmail($this->username);
        }

        return $this->_user;
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('user', 'Email'),
            'password' => Yii::t('user', 'Password'),
            'rememberMe' => Yii::t('user', 'Remember me'),
        ];
    }
}
