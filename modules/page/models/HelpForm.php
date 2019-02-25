<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace page\models;

use user\models\User;
use Yii;
use yii\base\Model;
use yii\behaviors\AttributeBehavior;
use yii\helpers\Html;
use yii\web\JsExpression;


/**
 * ContactForm is the model behind the contact form.
 *
 * @property User $user
 */
class HelpForm extends Model
{
    public $name;
    public $phone;
    public $email;

    public $subject;
    public $body;

    public $IP;
    public $user_id;
    public $page_url;
    public $date;



    public function init()
    {
        parent::init();

        $this->IP = Yii::$app->request->userIP;

        if(Yii::$app->user->id){
            $this->user_id = Yii::$app->user->id;
            $this->name = Yii::$app->user->identity->fullName;
            $this->email = Yii::$app->user->identity->email;
        }

        $this->date = date('Y-m-d H:i:s');

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'safe'],
            [['body'], 'required'],
            [['subject'], 'required'],
            [['email'], 'email'],
            [
                'phone', 'required', 'when'=>function(self $model) {
                                                            return !$model->email;
                                                        },
                                        'whenClient' => "function (attribute, value) {
                                                                //alert(attribute.id);
                                                                return !$('#helpform-email').val();
                                                            }",
            ],
            [
                'email', 'required', 'when'=>function(self $model)
                                            {
                                                return !$model->phone;
                                            },
                                            'whenClient' => "function (attribute, value) {
                                                                return !$('#helpform-phone').val();
                                                            }",
            ],
            ['page_url', 'string']
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'=>Yii::t('page', 'Your name'),
            'phone'=>Yii::t('common', 'Phone'),
            'email'=>Yii::t('common', 'Email'),
            'body'=>Yii::t('common', 'Message'),
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
        $user = $this->user_id ? Html::a($this->user->fullName,
            Yii::$app->urlManagerBackend->createAbsoluteUrl(['/user/manage/index/view', 'id'=>$this->user_id])):null;
        $page_url = Html::a($this->page_url, $this->page_url);

        Yii::$app->mailer->viewPath = '@page/mail';
        return Yii::$app->mailer->compose('help-html', ['model' => $this, 'user'=>$user, 'page_url'=>$page_url])
            ->setTo([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setSubject($this->subject)
            ->send();
    }

    public function getUser()
    {
        return User::findOne($this->user_id);
    }
}
