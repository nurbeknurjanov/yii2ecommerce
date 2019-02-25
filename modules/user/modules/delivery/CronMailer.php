<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */


namespace delivery;


use delivery\models\CronEmailMessage;
use yii\base\Exception;
use yii\helpers\Html;
use yii\swiftmailer\Mailer;

class CronMailer extends Mailer
{
    public $messageClass = 'delivery\Message'; //Заглушка
    public $_body;
    public function send($message)
    {
        $cronEmailMessage = new CronEmailMessage;
        $cronEmailMessage->subject = $message->getSubject();
        $cronEmailMessage->body = $message->getBody();
        $from = $message->getFrom();
        $cronEmailMessage->sender_email = key($from);
        $cronEmailMessage->sender_name = reset($from);

        foreach ($message->getTo() as $toEmail=>$toName) {
            $cronEmailMessage->recipient_email = $toEmail;
            $cronEmailMessage->recipient_name = $toName;
            if(!$cronEmailMessage->save())
                throw  new  Exception("Cron email message is not saved.");
        }
        return true;
    }

} 