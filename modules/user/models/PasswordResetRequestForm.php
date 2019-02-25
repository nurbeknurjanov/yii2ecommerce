<?php

namespace user\models;

use user\models\create\TokenCreate;
use user\models\User;
use yii\base\Model;
use Yii;
use user\models\Token;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\user\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with such email.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if ($user) {
            $token = TokenCreate::createForPasswordReset($user);
            return Yii::$app->mailer->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user, 'token'=>$token,])
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
                ->setTo([$user->email=>$user->fullName])
                ->setSubject(Yii::t('user', 'Password reset for {appName}', ['appName'=>Yii::$app->name,]))
                ->send();
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'email'=>Yii::t('user', 'Email'),
        ];
    }
}
