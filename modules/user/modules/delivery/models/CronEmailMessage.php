<?php

namespace delivery\models;

use delivery\models\query\CronEmailMessageQuery;
use Yii;
use yii\behaviors\AttributeBehavior;

/**
 * This is the model class for table "{{%cron_email_message}}".
 *
 * @property integer $id
 * @property string $created_date
 * @property string $recipient_email
 * @property string $recipient_name
 * @property string $sender_email
 * @property string $sender_name
 * @property string $subject
 * @property string $body
 * @property integer $status
 * @property string $sent_date
 */
class CronEmailMessage extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes'=>[
                    self::EVENT_BEFORE_INSERT => ['created_date'],
                ],
                'value'=>date('Y-m-d H:i:s'),
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes'=>[
                    self::EVENT_BEFORE_INSERT => ['status'],
                ],
                'value'=>self::STATUS_OPEN,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cron_email_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recipient_email', 'sender_email', 'subject', 'body'], 'required'],
            [['created_date', 'body', 'sent_date'], 'safe'],
            [['status'], 'integer'],
            [['recipient_email', 'recipient_name', 'sender_email', 'sender_name', 'subject'], 'string', 'max' => 255],
            [['recipient_name', 'sender_name'], 'default', 'value' => ''],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'created_date' => Yii::t('common', 'Created Date'),
            'recipient_email' => Yii::t('common', 'Recipient Email'),
            'recipient_name' => Yii::t('common', 'Recipient Name'),
            'sender_email' => Yii::t('common', 'Sender Email'),
            'sender_name' => Yii::t('common', 'Sender Name'),
            'subject' => Yii::t('common', 'Subject'),
            'body' => Yii::t('common', 'Body'),
            'status' => Yii::t('common', 'Status'),
            'sent_date' => Yii::t('common', 'Sent Date'),
        ];
    }

    /**
     * @inheritdoc
     * @return \delivery\models\query\CronEmailMessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CronEmailMessageQuery(get_called_class());
    }

    const STATUS_OPEN = 0;
    const STATUS_SENT = 1;
    public $statusValues = [
        self::STATUS_OPEN=>'Open',
        self::STATUS_SENT=>'Sent',
    ];
    public function getStatusText()
    {
        return isset($this->statusValues[$this->status]) ? $this->statusValues[$this->status]:null;
    }
}
