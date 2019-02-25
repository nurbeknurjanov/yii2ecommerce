<?php

namespace user\models;

use user\models\Token;
use user\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $password_repeat;

    /**
     * @var \user\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if($token = Token::findOne(['token'=>$token,])){
            if($token->expire_date<date('Y-m-d H:i:s'))
                throw new InvalidParamException('The token is expired.');
            if($token->run==1)
                throw new InvalidParamException('The token can not be run twice.');
            $this->_user = $token->user;
        }
        if (!$this->_user)
            throw new InvalidParamException('Wrong password reset token.');
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'password_repeat'], 'required'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $token = Token::findOne(['token'=>Yii::$app->request->get('token'),]);
        Yii::$app->mailer->compose()
            ->setTo([$user->email=>$user->fullName,])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setSubject(Yii::t('user', 'You successfully set new password.'))
            ->setHtmlBody(Yii::t('user', 'You successfully set new password.'))
            ->send();
        $token->delete();
        return $user->save(false);
    }
}
