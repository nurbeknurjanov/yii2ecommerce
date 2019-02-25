<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace console\controllers;

use yii\console\Controller;
use delivery\models\CronEmailMessage;
use user\models\User;
use user\models\Token;
use Yii;
use yii\base\Exception;

class CronController extends Controller
{
    public function actionSendEmailMessages()
    {
        $cronEmailMessages = CronEmailMessage::find()->open()->limit(10)->all();
        foreach ($cronEmailMessages as $cronEmailMessage) {
            $mailer = Yii::$app->mailer;
            //$mailer->useFileTransport = !YII_ENV_PROD;

            $mailer->compose()
                ->setTo([$cronEmailMessage->recipient_email=>$cronEmailMessage->recipient_name])
                ->setFrom([$cronEmailMessage->sender_email => $cronEmailMessage->sender_name])
                ->setSubject($cronEmailMessage->subject)
                ->setTextBody($cronEmailMessage->body)
                ->send();

            $cronEmailMessage->status = CronEmailMessage::STATUS_SENT;
            $cronEmailMessage->sent_date = date('Y-m-d H:i:s');
            $cronEmailMessage->save();
        }
        echo "Cron successfully sent email messages!\n";
    }
}