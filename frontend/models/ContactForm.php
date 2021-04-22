<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\JsExpression;
use \himiklab\yii2\recaptcha\ReCaptchaValidator;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $phone;
    public $subject;
    public $body;
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'subject'=>['subject', 'required'],
            ['phone', 'safe'],
            // name, email, subject and body are required
            [['name', 'email', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            ['reCaptcha', ReCaptchaValidator::class,
                'when'=>function($model){
                    if(Yii::$app->request->isAjax)
                        return false;
                    if(Yii::$app->request->post('ajax')=='contact-form')
                        return false;
                    if(YII_ENV_TEST)
                        return false;
                    return true ;
                }],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'=>Yii::t('common', 'Name'),
            'phone'=>Yii::t('common', 'Phone'),
            'subject'=>Yii::t('db_frontend', 'Subject'),
            'body'=>Yii::t('common', 'Text'),
            'reCaptcha'=>Yii::t('common', 'I\'m not a robot'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail()
    {

		Yii::$app->mailer->compose()
            ->setTo([$this->email=>$this->name])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setSubject(Yii::t('common', 'Thank you for contacting us. We will respond to you as soon as possible.'))
            ->setHtmlBody(Yii::t('common', 'Thank you for contacting us. We will respond to you as soon as possible.'))
            ->send();

        return Yii::$app->mailer->compose()
            ->setTo(Yii::$app->params['supportEmail'])
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setHtmlBody("
            $this->body <br>
            {$this->getAttributeLabel('name')}:{$this->name} <br/>
            {$this->getAttributeLabel('email')}:{$this->email} <br/>
            {$this->getAttributeLabel('phone')}:{$this->phone} <br/>
            ")
            ->send();
    }
}
