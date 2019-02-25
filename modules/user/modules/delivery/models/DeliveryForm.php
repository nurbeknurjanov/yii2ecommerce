<?php
namespace delivery\models;

use delivery\models\CronEmailMessage;
use user\models\Token;
use Yii;
use yii\base\Model;
use yii\helpers\Html;

/**
 * Delivery form
 */
class DeliveryForm extends Model
{
    public $recipients;
    public $type;
    public $role;
    public $subscribe;

    const TYPE_IMMEDIATELY=1;
    const TYPE_LATER=2;
    public $typeValues = [
        self::TYPE_IMMEDIATELY=>'Immediately',
        self::TYPE_LATER=>'Later',
    ];


    public $subject;
    public $body;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recipients'], 'required', 'when'=>function($model) {
                    return !$model->role;
                }, 'whenClient' => "function (attribute, value) {
                        return !$('#deliveryform-role').val();
                    }"],
            [['role'], 'required', 'when'=>function($model) {
                    return !$model->recipients;
                }, 'whenClient' => "function (attribute, value) {
                        return !$('#deliveryform-recipients').val();
                    }"],
            [['role'], 'safe'],
            [['recipients'], 'required'],
            [['subject', 'body', 'type'], 'required'],
        ];
    }



    public function sendMessages()
    {
        foreach ($this->recipients as $recipient) {
            $recipient = explode('|', $recipient);
            $email = $recipient[0];
            $name = $recipient[1];

            switch($this->type){
                case self::TYPE_IMMEDIATELY: {
                    Yii::$app->mailer->compose('delivery-html', ['content'=>$this->body, 'email'=>$email, ])
                        ->setFrom([Yii::$app->params['supportEmail']=>Yii::$app->name])
                        ->setTo([$email=>$name])
                        ->setSubject($this->subject)
                        ->send();
                    break;
                }
                case self::TYPE_LATER: {
                    Yii::$app->cronMailer->compose('delivery-html', ['content'=>$this->body , 'email'=>$email,])
                        ->setFrom([Yii::$app->params['supportEmail']=>Yii::$app->name])
                        ->setTo([$email=>$name])
                        ->setSubject($this->subject)
                        ->send();
                    break;
                }
            }
        }

        switch($this->type){
            case self::TYPE_IMMEDIATELY: {
                Yii::$app->session->setFlash('success', "The messages successfully sent to emails");
                break;
            }
            case self::TYPE_LATER: {
                Yii::$app->session->setFlash('success', "The messages successfully sent to cron");
                break;
            }
        }

    }
    public function attributeLabels()
    {
        return [
            'role'=>'Role of recipients',
        ];
    }
}
