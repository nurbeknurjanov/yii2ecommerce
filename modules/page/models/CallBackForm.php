<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace page\models;

use Yii;
use yii\base\Model;
use yii\web\JsExpression;

/**
 * ContactForm is the model behind the contact form.
 */
class CallBackForm extends Model
{
    public $name;
    public $phone;
    public $subject;
    public $body;
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'body'], 'safe'],
            [['phone', 'subject'], 'required'],
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
            'body'=>Yii::t('common', 'Comment'),
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
        return Yii::$app->mailer->compose()
            ->setTo([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setSubject($this->subject)
            ->setHtmlBody("
            {$this->getAttributeLabel('name')}:{$this->name} <br>
            {$this->getAttributeLabel('phone')}:{$this->phone} <br>
            {$this->getAttributeLabel('body')}:{$this->body} <br>
            ")
            ->send();
    }
}
