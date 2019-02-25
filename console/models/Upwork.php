<?php

namespace console\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\AfterSaveEvent;
use yii\helpers\Html;
use yii\httpclient\Client;

/**
 * This is the model class for table "{{%upwork}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $date
 * @property string $description
 * @property string $link
 * @property string $guid
 */
class Upwork extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%upwork}}';
    }


    public static $_client;
    public function getClient()
    {
        if(self::$_client)
            return self::$_client;

        $client = new Client();
        /*$response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl('https://www.upwork.com/ab/account-security/login')
            ->setData(['login[username]' => 'nurbek.nurjanov@mail.ru'])
            ->send();
        if ($response->isOk) {
            $content = $response->content;
            //$newUserId = $response->data['id'];*/
        //login[password]

        return self::$_client=$client;

    }

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_AFTER_INSERT, function($event){
            /* @var $model self */
            $model = $event->sender;


            $client = new Client();
            $response = $client->createRequest()
                ->setUrl($this->link)
                ->send();
            if ($response->isOk)
            {
                $content = $response->content;
                if(strpos($content, 'Access is restricted to Upwork users only.') !== false)
                    $continue=1;
                else{

                    if (
                        strpos($content, 'Payment method not verified') !== false
                        ||
                        strpos($content, 'Fixed-price') !== false
                        ||
                        strpos($content, 'Entry level') !== false
                        ||
                        strpos($content, '<strong class="primary">India</strong>') !== false
                    ){
                        return true;
                    }
                }
            }


            $SMSRU = new SMSRU('F74022CE-4ADA-F47D-F3D3-B45579ADEEA2');
            $data = new \stdClass();
            $data->to = '996558011477';
            $data->text = $model->title;
            $data->from = '996558011477';
            $data->translit = 1;
            $sms = $SMSRU->send_one($data);

            if ($sms->status == "OK")
                echo "Сообщение отправлено успешно. "."ID сообщения: $sms->sms_id. "."Ваш новый баланс: $sms->balance";
            else {

                $SMSRU = new SMSRU('AE11D47D-4504-C9A5-0286-5E09A4C9E504');
                $data = new \stdClass();
                $data->to = '996700011476';
                $data->text = $model->title;
                $data->from = '996700011476';
                $data->translit = 1;
                $sms = $SMSRU->send_one($data);

                if ($sms->status == "OK")
                    echo "Сообщение отправлено успешно. "."ID сообщения: $sms->sms_id. "."Ваш новый баланс: $sms->balance";
                else
                    echo "Сообщение не отправлено. "."Код ошибки: $sms->status_code. "."Текст ошибки: $sms->status_text.";
            }

            Yii::$app->mailer->compose()
                    ->setTo(['nurbek.nurjanov@mail.ru'=>'Нурбек Нуржанов'])
                    ->setFrom([Yii::$app->params['supportEmail'] => 'Upwork-S'])
                    ->setSubject($model->title)
                    ->setHtmlBody("
                    Title:$model->title<br><br>
                    Date:".Yii::$app->formatter->asDatetime($model->date)."<br><br>
                    Description:$model->description<br><br>
                    ")
                    ->send();

        });
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'date', 'description', 'link', 'guid'], 'required'],
            [['date'], 'safe'],
            [['description'], 'string'],
            [['title', 'description', 'link', 'guid'], 'default', 'value'=>''],
            [['date'], 'default', 'value'=>'0000-00-00 00:00:00'],
            [['title', 'link', 'guid'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'title' => Yii::t('common', 'Title'),
            'date' => Yii::t('common', 'Date'),
            'description' => Yii::t('common', 'Description'),
            'link' => Yii::t('common', 'Link'),
            'guid' => Yii::t('common', 'Guid'),
        ];
    }

    /**
     * @inheritdoc
     * @return UpworkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UpworkQuery(get_called_class());
    }



}