<?php

namespace extended\i18n;

use i18n\models\I18nMessage;
use i18n\models\I18nSourceMessage;
use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\i18n\MissingTranslationEvent;
use yii\i18n\DbMessageSource;

class MissingTranslationEventHandler extends Component
{
    public $warningLog=true;
    public $sendEmail=false;
    public $automaticallyCreateNewRecord = true;
    public static $source_records=[];
    public static $message_records=[];
    public function handleMissingTranslation(MissingTranslationEvent $event)
    {
        $sender = $event->sender;

        if(Yii::$app->sourceLanguage == $event->language)
            return false;
        if($sender instanceof DbMessageSource && $this->automaticallyCreateNewRecord)
        {
            if(self::$source_records===[])
                self::$source_records = I18nSourceMessage::find()->indexBy('message')->all();
            if(self::$message_records===[])
                self::$message_records = I18nMessage::find()->language()->indexBy('id')->all();

            if(!isset(self::$source_records[$event->message])){
                $model = new I18nSourceMessage();
                $model->category = $event->category;
                $model->message=$event->message;
                $model->save();
            }else
                $model = self::$source_records[$event->message];
            if(!isset(self::$message_records[$model->id])){
                $message = new I18nMessage();
                $message->id = $model->id;
                $message->language = $event->language;
                $message->save();
            }
        }
        if($this->sendEmail)
            Yii::$app->mailer->compose()
                ->setTo([Yii::$app->params['adminEmail'] => Yii::$app->name])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setSubject("Missing translation found.")
                ->setHtmlBody("Missing translation found.<br>
                        Category: {$event->category}<br>
                        Message: {$event->message}<br>
                        Language: {$event->language}")
                ->send();

        if($this->warningLog){
            Yii::warning("Missing translation found.
                        Category: {$event->category}
                        Message: {$event->message}
                        Language: {$event->language}", 'i18n');
        }
    }
}