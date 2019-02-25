<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace i18n\models;

use i18n\models\query\I18nMessageQuery;
use Yii;
use yii\base\Event;
use yii\base\Exception;

/**
 * This is the model class for table "{{%i18n_source_message}}".
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * @property I18nMessage[] $i18nMessages
 */
class I18nSourceMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%i18n_source_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['category', 'message'], 'required'],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'category' => Yii::t('common', 'Category'),
            'message' => Yii::t('common', 'Message'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI18nMessages()
    {
        return $this->hasMany(I18nMessage::className(), ['id' => 'id']);
    }

    public $languageValues = [
        'en-US'=>'English',
        'ru'=>'Русский',
    ];
    public $categoryValues = [
        'db_frontend'=>'db_frontend',
        'db_category'=>'db_category',
    ];

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_BEFORE_DELETE, function(Event $event){
            /* @var $model self */
            $model = $event->sender;
            if($model->getMessages()->translated()->exists())
                throw new Exception("This message has translates. Delete translates before delete.");
        });

        $this->on(static::EVENT_AFTER_INSERT, [$this, 'deleteCache']);
        $this->on(static::EVENT_AFTER_UPDATE, [$this, 'deleteCache']);
        $this->on(static::EVENT_AFTER_DELETE, [$this, 'deleteCache']);
    }

    public function deleteCache()
    {
        Yii::$app->cache->flush();
    }

    /**
     * @return I18nMessageQuery
     * */
    public function getMessages()
    {
        return $this->hasMany(I18nMessage::className(), ['id' => 'id']);
    }
}
